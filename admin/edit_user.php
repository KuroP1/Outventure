<?php


//check session isAdmin is >0
session_start();
if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] <= 0) {
    header("Location: ../index.php");
    exit();
}

require_once("../config/database.php");
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_GET["id"];
    $name = $_POST["Username"];
    $email = $_POST["email"];

    if (empty($name) == true || empty($email)) {
        echo "<script>
        alert('Fill cannot be empty.');
        window.location.href='edit_user.php?id=$_GET[id]';
        </script>";
    } else {
        //update user info
        $updateUserquery = "UPDATE users SET Username = ?, email = ?, password = ? WHERE UserID = ?";
        $stmt = $conn->prepare($updateUserquery);
        $stmt->bind_param('sssi', $name, $email, $password, $id);
        $stmt->execute();
        header("Location: user.php");
        exit();
    }
} else {
    $id = $_GET["id"];
    // Get the user's information query
    $getUserAccount = "SELECT * FROM users WHERE UserID = ?";
    $stmt = $conn->prepare($getUserAccount);
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $account = $result->fetch_assoc();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="../global.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" type="image/x-icon" href="../images/Logo_Small.png">
    <script src="admin.js"></script>
    <title>Document</title>
</head>

<body onload="toUserManage()">
    <div class="side_bar">
        <a href='/'>
            <img class="logo" width='200px' src="../images/Logo2.png" alt="logo2" class="logo2">
        </a>
        <div class="nav_section">
            <a href="/admin/user.php" id="user-manage-btn" onclick="toUserManage()">User Manage</a>
            <a href="/admin/product.php" id="product-manage-btn" onclick="toProductManage()">Product
                Manage</a>
            <a href="/admin/order.php" id="order-history-btn" onclick="toOrderHistory()">Order History</a>
            <a href="/admin/category.php" id="category-btn" onclick="toCategory()">
                Category Manage</a>
        </div>
        <img class="logo" src="../images/Logo.png" alt="logo2" class="logo2">
    </div>

    <div class="user-edit-section" id="user-edit-section">
        <div class="content" id="content">
            <div class="title">
                User Manage
            </div>
            <hr class="h-line">
            <div class="top-section">
                <div class="sub-title">
                    User Edit
                </div>
            </div>
            <div class="product-edit-container">
                <div class="product-edit-content">
                    <form action="edit_user.php?id=<?php echo $account["UserID"]; ?>" method="POST">
                        <div class="container">
                            <div class="col-12">
                                <div class='avatar-container'>
                                    <div class="avatar">
                                        <div class="avatar-text">
                                            <?php echo strtoupper($account["Username"][0]); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 pt-4 edit-btn-container">
                                <label class="edit-image-btn">
                                    <input id="upload_img" style="display:none;" type="file" name="productImage[]" multiple require>
                                    <div id="file-upload-filename">
                                        <span>Upload Image</span>
                                        <svg class='mb-1' width=" 18" height="17" viewBox="0 0 18 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M16.7974 0.745559C15.7726 -0.230749 14.1112 -0.230758 13.0865 0.745559L11.6172 2.14539L4.70189 8.73368C4.58979 8.84052 4.51027 8.97435 4.47182 9.12085L3.59713 12.4542C3.52261 12.7382 3.60994 13.0386 3.8272 13.2455C4.04445 13.4525 4.35977 13.5358 4.65785 13.4648L8.15656 12.6314C8.31041 12.5948 8.4508 12.519 8.56294 12.4122L15.4279 5.87183L16.9475 4.42407C17.9723 3.44776 17.9723 1.86484 16.9475 0.888534L16.7974 0.745559ZM14.3234 1.92407C14.665 1.59863 15.2189 1.59863 15.5604 1.92407L15.7105 2.06704C16.0521 2.39248 16.0521 2.92013 15.7105 3.24556L14.8214 4.09266L13.4609 2.74583L14.3234 1.92407ZM12.2237 3.92456L13.5842 5.27138L7.49731 11.0705L5.64784 11.511L6.11019 9.74902L12.2237 3.92456ZM1.82164 5.1563C1.82164 4.69607 2.21325 4.32297 2.69633 4.32297H7.06976C7.55285 4.32297 7.94445 3.94988 7.94445 3.48963C7.94445 3.0294 7.55285 2.6563 7.06976 2.6563H2.69633C1.2471 2.6563 0.0722656 3.77559 0.0722656 5.1563V14.3229C0.0722656 15.7037 1.2471 16.8229 2.69633 16.8229H12.3179C13.7671 16.8229 14.9419 15.7037 14.9419 14.3229V10.1563C14.9419 9.6961 14.5503 9.32293 14.0673 9.32293C13.5842 9.32293 13.1926 9.6961 13.1926 10.1563V14.3229C13.1926 14.7832 12.801 15.1563 12.3179 15.1563H2.69633C2.21325 15.1563 1.82164 14.7832 1.82164 14.3229V5.1563Z" fill="white" />
                                        </svg>
                                    </div>
                                </label>
                            </div>

                            <div class="col-12 pt-3 ">
                                <div class='field'>
                                    User ID:
                                    <input class='name-edit-input' type="text" name="id" value="<?php echo $account["UserID"]; ?>" readonly>
                                    </input>
                                </div>
                                <div class='field'>
                                    User Name:
                                    <input class='name-edit-input' type="text" name="Username" value="<?php echo $account["Username"]; ?>">
                                    </input>
                                </div>
                                <div class='field'>
                                    User Email:
                                    <input class='name-edit-input' type="text" name="email" value="<?php echo $account["Email"]; ?>">
                                    </input>
                                </div>
                            </div>

                            <div class="col-12 ">
                                <div class='button-section'>
                                    <button class='update-btn' type="submit">
                                        Update
                                        <svg class='mb-1' width="15" height="15" 0 viewBox="0 0 17 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_185_1067)">
                                                <path d="M8.47266 17.5251C5.73932 17.5251 3.27266 16.1084 1.80599 13.7001V17.5251H0.472656V11.1501H6.47266V12.5667H2.67266C3.87266 14.7626 6.00599 16.1084 8.47266 16.1084C12.1393 16.1084 15.1393 12.9209 15.1393 9.02505H16.4727C16.4727 13.7001 12.8727 17.5251 8.47266 17.5251ZM1.80599 9.02505H0.472656C0.472656 4.35005 4.07266 0.525055 8.47266 0.525055C11.206 0.525055 13.6727 1.94172 15.1393 4.35005V0.525055H16.4727V6.90005H10.4727V5.48339H14.2727C13.0727 3.28755 10.9393 1.94172 8.47266 1.94172C4.80599 1.94172 1.80599 5.12922 1.80599 9.02505Z" fill="white" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_185_1067">
                                                    <rect width="16" height="17" fill="white" transform="translate(0.472656 0.525055)" />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </button>
                                    <a href='delete_user.php?name=<?php echo $account["Username"]; ?>'>
                                        <button class='delete-btn' type="button">
                                            Delete
                                            <svg class='mb-1' width="18" height="18" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_185_1073)">
                                                    <path d="M8.7313 16.2285C8.54366 16.2485 8.37559 16.1115 8.3558 15.9225L7.74409 10.0722C7.72437 9.88334 7.86044 9.71405 8.04809 9.69419L8.3878 9.65819C8.57544 9.63834 8.74359 9.77534 8.7633 9.96419L9.37501 15.8146C9.3948 16.0035 9.25873 16.1727 9.07109 16.1926L8.7313 16.2285Z" fill="white" />
                                                    <path d="M11.8059 16.1926C11.6183 16.1727 11.4822 16.0035 11.5019 15.8146L12.1136 9.96419C12.1334 9.77534 12.3015 9.63834 12.4891 9.65819L12.8288 9.69419C13.0165 9.71405 13.1526 9.88334 13.1328 10.0722L12.5211 15.9225C12.5014 16.1115 12.3333 16.2485 12.1456 16.2285L11.8059 16.1926Z" fill="white" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.78394 0.734131C8.37401 0.734131 8.00344 0.980095 7.84194 1.35945L7.08333 3.14154H3.77661C3.02194 3.14154 2.41016 3.75745 2.41016 4.5172V6.23677C2.41016 6.93787 2.93111 7.51649 3.60457 7.60163L5.71683 18.7526C5.7807 19.0741 6.06111 19.3056 6.38679 19.3056H14.8035C15.1417 19.3056 15.429 19.0565 15.4792 18.7198L17.0149 7.58813C17.6468 7.46713 18.1244 6.9081 18.1244 6.23677V4.5172C18.1244 3.75745 17.5127 3.14154 16.758 3.14154H13.4502L12.6916 1.35945C12.5301 0.980095 12.1596 0.734131 11.7496 0.734131H8.78394ZM11.9635 3.14154L11.7018 2.52667C11.5942 2.27377 11.3471 2.1098 11.0738 2.1098H9.45973C9.18644 2.1098 8.93944 2.27377 8.83173 2.52667L8.57001 3.14154H11.9635ZM15.6026 7.91385C15.6264 7.74185 15.4926 7.58849 15.3189 7.58892L5.34894 7.61163C5.17023 7.61206 5.03576 7.77456 5.06881 7.9502L6.83734 17.3477C6.90088 17.6853 7.19576 17.9299 7.5393 17.9299H13.5929C13.9496 17.9299 14.2516 17.6668 14.3005 17.3136L15.6026 7.91385ZM16.0747 6.23677C16.4521 6.23677 16.758 5.92882 16.758 5.54894V5.20503C16.758 4.82515 16.4521 4.5172 16.0747 4.5172H4.45985C4.08251 4.5172 3.77661 4.82515 3.77661 5.20503V5.54894C3.77661 5.92882 4.08251 6.23677 4.45984 6.23677H16.0747Z" fill="white" />
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_185_1073">
                                                        <rect width="20" height="20" fill="white" transform="translate(0.267578 0.0198364)" />
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
            <!-- end of table -->
            <div class=" burger_container">
                <svg id="burger-btn" class="ham hamRotate ham1" viewBox="0 0 100 100" width="60" onclick="toggleActive()">
                    <path class="line top" d="m 30,33 h 40 c 0,0 9.044436,-0.654587 9.044436,-8.508902 0,-7.854315 -8.024349,-11.958003 -14.89975,-10.85914 -6.875401,1.098863 -13.637059,4.171617 -13.637059,16.368042 v 40" />
                    <path class="line middle" d="m 30,50 h 40" />
                    <path class="line bottom" d="m 30,67 h 40 c 12.796276,0 15.357889,-11.717785 15.357889,-26.851538 0,-15.133752 -4.786586,-27.274118 -16.667516,-27.274118 -11.88093,0 -18.499247,6.994427 -18.435284,17.125656 l 0.252538,40" />
                </svg>
            </div>
            <div class="dropdown-container" id="dropdown-container">
                <div class="dropdown-content">
                    <img class="logo" src="../images/Logo2.png" alt="logo2" class="logo2">
                    <div class="nav_section">
                        <a href="/admin/user.php" id="user-manage-btn" onclick="toUserManage()">User
                            Manage</a>
                        <a href="/admin/product.php" id="product-manage-btn" onclick="toProductManage()">Product Manage</a>
                        <a href="/admin/order.php" id="order-history-btn" onclick="toOrderHistory()">Order
                            History</a>
                        <a href="/admin/category.php" id="category-btn" onclick="toCategory()">
                            Category Manage</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>

</html>