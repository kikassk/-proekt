<?php
declare(strict_types=1);

namespace App\Controllers;

use Hleb\Base\Controller;
use Hleb\Static\DB;

class CartController extends Controller
{
    private function ensureTestUserExists() {
        $user = DB::run("SELECT id FROM users WHERE id = ?", [1])->fetch();
        if (!$user) {
            DB::run("INSERT INTO users (id, name, email, password) VALUES (?, ?, ?, ?)", [1, 'Test User', 'test@example.com', 'password']);
        }
    }

    public function getCart()
    {
        try {
            $this->ensureTestUserExists(); // <-- ДОБАВЛЕНО: Убедимся, что пользователь есть
            $userId = 1;

            $cart = DB::run("SELECT id FROM carts WHERE user_id = ?", [$userId])->fetch();
            if (!$cart) {
                DB::run("INSERT INTO carts (user_id) VALUES (?)", [$userId]);
                $cartId = DB::run("SELECT LAST_INSERT_ID() as id")->fetch()['id'];
                $items = [];
            } else {
                $cartId = $cart['id'];
                $items = DB::run("
                    SELECT ci.id, ci.product_id, ci.quantity, p.name, p.price, p.image_url
                    FROM cart_items ci
                    JOIN products p ON p.id = ci.product_id
                    WHERE ci.cart_id = ?
                ", [$cartId])->fetchAll();
            }

            $totalPrice = 0;
            $totalItems = 0;
            foreach ($items as $item) {
                $totalPrice += $item['price'] * $item['quantity'];
                $totalItems += $item['quantity'];
            }

            return [
                'items' => $items,
                'total_price' => $totalPrice,
                'total_items' => $totalItems,
            ];
        } catch (\Throwable $e) {
            http_response_code(500);
            return ['error' => 'Internal Server Error', 'message' => $e->getMessage()];
        }
    }

    public function addProduct()
    {
        try {
            $this->ensureTestUserExists(); // <-- ДОБАВЛЕНО: Убедимся, что пользователь есть
            $userId = 1;
            $input = json_decode(file_get_contents('php://input'), true) ?? [];
            $productId = (int)($input['product_id'] ?? 0);
            $quantity = (int)($input['quantity'] ?? 1);

            if (!$productId || $quantity <= 0) {
                 http_response_code(400);
                 return ['success' => false, 'message' => 'Invalid product ID or quantity.'];
            }
             // Также нужно убедиться, что товар существует
            $product = DB::run("SELECT id FROM products WHERE id = ?", [$productId])->fetch();
            if (!$product) {
                http_response_code(404);
                return ['success' => false, 'message' => 'Product not found.'];
            }


            $cart = DB::run("SELECT id FROM carts WHERE user_id = ?", [$userId])->fetch();
            if (!$cart) {
                 DB::run("INSERT INTO carts (user_id) VALUES (?)", [$userId]);
                 $cartId = DB::run("SELECT LAST_INSERT_ID() as id")->fetch()['id'];
            } else {
                 $cartId = $cart['id'];
            }

            $existingItem = DB::run("SELECT id, quantity FROM cart_items WHERE cart_id = ? AND product_id = ?", [$cartId, $productId])->fetch();
            if ($existingItem) {
                $newQuantity = $existingItem['quantity'] + $quantity;
                DB::run("UPDATE cart_items SET quantity = ? WHERE id = ?", [$newQuantity, $existingItem['id']]);
            } else {
                DB::run("INSERT INTO cart_items (cart_id, product_id, quantity) VALUES (?, ?, ?)", [$cartId, $productId, $quantity]);
            }

            return ['success' => true, 'message' => 'Product added/updated in cart.'];
        } catch (\Throwable $e) {
            http_response_code(500);
            return ['error' => 'Internal Server Error', 'message' => $e->getMessage()];
        }
    }
    
    public function updateQuantity(int $itemId)
    {
        try {
            $userId = 1;
            $input = json_decode(file_get_contents('php://input'), true) ?? [];
            $quantity = (int)($input['quantity'] ?? 0);
            
            $item = DB::run("SELECT ci.id FROM cart_items ci JOIN carts c ON c.id = ci.cart_id WHERE ci.id = ? AND c.user_id = ?", [$itemId, $userId])->fetch();

            if (!$item || $quantity <= 0) {
                http_response_code(400);
                return ['success' => false, 'message' => 'Item not found or invalid quantity.'];
            }

            DB::run("UPDATE cart_items SET quantity = ? WHERE id = ?", [$quantity, $itemId]);
            
            return ['success' => true];
        } catch (\Throwable $e) {
            http_response_code(500);
            return ['error' => 'Internal Server Error', 'message' => $e->getMessage()];
        }
    }

    public function removeItem(int $itemId)
    {
        try {
            $userId = 1;
            $item = DB::run("SELECT ci.id FROM cart_items ci JOIN carts c ON c.id = ci.cart_id WHERE ci.id = ? AND c.user_id = ?", [$itemId, $userId])->fetch();

            if ($item) {
                DB::run("DELETE FROM cart_items WHERE id = ?", [$itemId]);
            }
            
            http_response_code(204);
            return null;
        } catch (\Throwable $e) {
            http_response_code(500);
            return ['error' => 'Internal Server Error', 'message' => $e->getMessage()];
        }
    }
}