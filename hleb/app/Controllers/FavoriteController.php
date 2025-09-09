<?php
declare(strict_types=1);
namespace App\Controllers;
use Hleb\Base\Controller;
use Hleb\Static\DB;

class FavoriteController extends Controller
{

private const USER_ID = 1;

public function getFavorites(): array
{
try 
{
$favorites = DB::run(
"SELECT p.id, p.name, p.description, p.price, p.image_url FROM favorites f JOIN products p ON f.product_id = p.id WHERE f.user_id = ?",
[self::USER_ID]
)->fetchAll();
return ['success' => true, 'favorites' => $favorites];
} catch (\Throwable $e) 
{
http_response_code(500);
return ['success' => false, 'error' => 'Failed to fetch favorites.', 'message' => $e->getMessage()];
}
}

public function addFavorite(): array
{
try 
{
$input = json_decode(file_get_contents('php://input'), true) ?? [];
$productId = (int)($input['product_id'] ?? 0);

if (!$productId) 
{
http_response_code(400);
return ['success' => false, 'message' => 'Invalid product ID.'];
}

$product = DB::run("SELECT id FROM products WHERE id = ?", [$productId])->fetch();
if (!$product) 
{
http_response_code(404);
return ['success' => false, 'message' => 'Product not found.'];
}

// Use INSERT IGNORE to prevent errors if the favorite already exists.
DB::run("INSERT IGNORE INTO favorites (user_id, product_id) VALUES (?, ?)", [self::USER_ID, $productId]);
return ['success' => true, 'message' => 'Product added to favorites.'];

} catch (\Throwable $e) 
{
http_response_code(500);
return ['error' => 'Internal Server Error', 'message' => $e->getMessage()];
}
}

public function removeFavorite(int $productId): ?array
{
try 
{
$result = DB::run("DELETE FROM favorites WHERE user_id = ? AND product_id = ?", [self::USER_ID, $productId]);
if ($result->rowCount() > 0) 
    {
return ['success' => true, 'message' => 'Product removed from favorites.'];
} else 
{
http_response_code(404);
return ['success' => false, 'message' => 'Favorite not found.'];
}
} catch (\Throwable $e) 
{
http_response_code(500);
return ['error' => 'Internal Server Error', 'message' => $e->getMessage()];
}
}
}