<?php

declare(strict_types=1);

namespace App\Controllers;

use Hleb\Base\Controller;
use Hleb\HttpMethods\External\Response;

class CartController extends Controller
{
    public function getCart(): Response
    {
        // Временные данные-заглушки
        $cartData = [
            'items' => [
                [
                    'id' => 1,
                    'product_id' => 101,
                    'name' => 'Супер-дрель 5000',
                    'price' => 1999.99,
                    'quantity' => 2,
                    'image_url' => 'https://example.com/images/drill.jpg'
                ]
            ],
            'total_price' => 3999.98,
            'total_items' => 2
        ];

        $jsonBody = json_encode($cartData);

        return new Response($jsonBody, 200, ['Content-Type' => 'application/json']);
    }

    public function addProduct(): Response
    {
        $productId = $this->request()->post('product_id')->asInt();
        $quantity = $this->request()->post('quantity')->asInt(1);

        $response = [
            'success' => true,
            'message' => "Product with ID {$productId} (quantity: {$quantity}) was added to cart.",
        ];

        return new Response(json_encode($response), 200, ['Content-Type' => 'application/json']);
    }


    public function updateQuantity(int $itemId): Response
    {
       
        $quantity = $this->request()->post('quantity')->asInt();

        

        $response = [
            'success' => true,
            'message' => "Quantity for item {$itemId} updated to {$quantity}.",
        ];

        return new Response(json_encode($response), 200, ['Content-Type' => 'application/json']);
    }

    public function removeItem(int $itemId): Response
    {
        // Здесь будет логика удаления товара с ID $itemId из корзины

        $response = [
            'success' => true,
            'message' => "Item {$itemId} removed from cart.",
        ];

        return new Response(json_encode($response), 204, ['Content-Type' => 'application/json']);
    }
}