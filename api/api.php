<?php
header("Content-Type: application/json; charset=UTF-8");
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "final";

// 建立資料庫連接，使用持久連接
$conn = new mysqli('p:localhost', $username, $password, $dbname);

// 檢查連接
if ($conn->connect_error) {
    die(json_encode(["message" => "Connection failed: " . $conn->connect_error]));
}

// 獲取請求方法和路徑
$method = $_SERVER['REQUEST_METHOD'];
$path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';

// 分割路徑信息
$request = explode('/', trim($path_info, '/'));

// 獲取資源和ID
$resource = array_shift($request);
$id = array_shift($request);

// 根據資源處理請求
switch ($resource) {
    case 'locations':
        handleRequest('Locations', $id, $method, $conn);
        break;
    case 'categories':
        handleRequest('Categories', $id, $method, $conn);
        break;
    case 'attractions':
        handleRequest('Attractions', $id, $method, $conn);
        break;
    default:
        http_response_code(404);
        echo json_encode(["message" => "Resource not found"]);
        break;
}

// 處理請求的函數
function handleRequest($table, $id, $method, $conn)
{
    switch ($method) {
        case 'GET':
            if ($id) {
                getItem($table, $id, $conn);
            } else {
                getItems($table, $conn);
            }
            break;
        case 'POST':
            addItem($table, $conn);
            break;
        case 'PUT':
            updateItem($table, $id, $conn);
            break;
        case 'DELETE':
            deleteItem($table, $id, $conn);
            break;
        default:
            http_response_code(405);
            echo json_encode(["message" => "Method not allowed"]);
            break;
    }
}

// 獲取所有項目
function getItems($table, $conn)
{
    $sql = "SELECT * FROM $table";
    $result = $conn->query($sql);

    if ($result) {
        $items = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($items);
    } else {
        http_response_code(500);
        echo json_encode(["message" => "Error fetching items: " . $conn->error]);
    }
}

// 獲取單個項目
function getItem($table, $id, $conn)
{
    $sql = "SELECT * FROM $table WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        http_response_code(404);
        echo json_encode(["message" => "Item not found"]);
    }
    $stmt->close();
}

// 新增項目
function addItem($table, $conn)
{
    $input = json_decode(file_get_contents('php://input'), true);
    if (is_array($input)) {
        foreach ($input as $key => $value) {
            if (is_array($value)) {
                $input[$key] = implode(' ', $value); // 將數組轉換為字符串
            }
        }

        $columns = implode(", ", array_keys($input));
        $placeholders = implode(", ", array_fill(0, count($input), "?"));
        $types = str_repeat("s", count($input)); // 假設所有輸入值都是字符串

        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $conn->prepare($sql);

        $values = array_values($input);
        $stmt->bind_param($types, ...$values);

        if ($stmt->execute() === TRUE) {
            http_response_code(201);
            echo json_encode(["message" => "New item created", "id" => $conn->insert_id]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Error creating item: " . $conn->error]);
        }
        $stmt->close();
    } else {
        http_response_code(400);
        echo json_encode(["message" => "Invalid input"]);
    }
}

// 更新項目
function updateItem($table, $id, $conn)
{
    $input = json_decode(file_get_contents('php://input'), true);
    if (is_array($input)) {
        $updates = [];
        $types = "";

        foreach ($input as $key => $value) {
            if (is_array($value)) {
                $value = implode(' ', $value); // 將數組轉換為字符串
            }
            $updates[] = "$key = ?";
            $types .= "s"; // 假設所有輸入值都是字符串
        }

        $updates_str = implode(", ", $updates);
        $sql = "UPDATE $table SET $updates_str WHERE id = ?";
        $stmt = $conn->prepare($sql);

        $values = array_values($input);
        $values[] = $id;
        $types .= "i"; // id 是整數

        $stmt->bind_param($types, ...$values);

        if ($stmt->execute() === TRUE) {
            echo json_encode(["message" => "Item updated"]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Error updating item: " . $conn->error]);
        }
        $stmt->close();
    } else {
        http_response_code(400);
        echo json_encode(["message" => "Invalid input"]);
    }
}

// 刪除項目
function deleteItem($table, $id, $conn)
{
    $sql = "DELETE FROM $table WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute() === TRUE) {
        echo json_encode(["message" => "Item deleted"]);
    } else {
        http_response_code(500);
        echo json_encode(["message" => "Error deleting item: " . $conn->error]);
    }
    $stmt->close();
}

$conn->close();
?>