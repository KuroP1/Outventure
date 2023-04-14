<?php
session_start();
if (!isset($_SESSION["currentUser"]) && !isset($_SESSION["isAdmin"])) {
    header("Location: ../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Outventure</title>
    <link rel="stylesheet" href="../global.css">
    <link rel="stylesheet" href="profile.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../images/Logo_Small.png">
    <script src="profile.js"></script>
    <script src=".././navbar.js"></script>
</head>

<body>
    <div>
        <!-- NavBar -->
        <div class="sub-navbar">
            <div class="sub-navbar-container">
                <a href="/"><img class="sub-navbar-logo" src="../images/Logo2.png" alt="Logo" /></a>
                <div onclick="ShowMobileMainMenu()" class="main-burger-tag-container">
                    <svg class="burger-tag" xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1);transform: msFilter;">
                        <path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"></path>
                    </svg>
                </div>
                <div class="sub-navbar-middle">
                    <a href="/index.php#product-section" class="sub-navbar-middle-text">Product</a>
                    <a href="/about_us/about_us.php" class="sub-navbar-middle-text">About Us</a>
                    <a href="#" class="sub-navbar-middle-text" style="color: #FFC700;">Profile</a>
                    <?php
                    if (isset($_SESSION["currentUser"])) {
                        echo '<a href="/authentication/logout.php" class="sub-navbar-middle-text">Logout</a>';
                    } else {
                        echo '<a href="/authentication/login.php" class="sub-navbar-middle-text">Login</a>';
                    }
                    ?>

                    <?php
                    if (isset($_SESSION["currentUser"]) && $_SESSION["isAdmin"] > "0") {
                        echo '<a href="/admin/user.php" class="sub-navbar-middle-text">Admin</a>';
                    }
                    ?>
                </div>
                <div class=" sub-navbar-right">
                    <div class="search-bar">
                        <form action="../search.php" method="GET">
                            <input class="search-bar-input" placeholder="Search Product" type"text" name="name" id="name">

                        </form>
                        <button class="search-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1);transform: msFilter;">
                                <path d="M19.023 16.977a35.13 35.13 0 0 1-1.367-1.384c-.372-.378-.596-.653-.596-.653l-2.8-1.337A6.962 6.962 0 0 0 16 9c0-3.859-3.14-7-7-7S2 5.141 2 9s3.14 7 7 7c1.763 0 3.37-.66 4.603-1.739l1.337 2.8s.275.224.653.596c.387.363.896.854 1.384 1.367l1.358 1.392.604.646 2.121-2.121-.646-.604c-.379-.372-.885-.866-1.391-1.36zM9 14c-2.757 0-5-2.243-5-5s2.243-5 5-5 5 2.243 5 5-2.243 5-5 5z">
                                </path>
                            </svg>
                        </button>
                        </input>
                    </div>
                    <span class="sub-navbar-right-vline">|</span>
                    <a class="cart_icon" href="/shopping_cart/shopping_cart.php" class="sub-navbar-middle-text">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1);transform: msFilter;">
                            <path d="M21.822 7.431A1 1 0 0 0 21 7H7.333L6.179 4.23A1.994 1.994 0 0 0 4.333 3H2v2h2.333l4.744 11.385A1 1 0 0 0 10 17h8c.417 0 .79-.259.937-.648l3-8a1 1 0 0 0-.115-.921zM17.307 15h-6.64l-2.5-6h11.39l-2.25 6z">
                            </path>
                            <circle cx="10.5" cy="19.5" r="1.5"></circle>
                            <circle cx="17.5" cy="19.5" r="1.5"></circle>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        <div id="mobile-sub-navbar-middle" style="transform: translateY(-100%); z-index: -1;">
            <a href="/index.php#product-section"" class=" sub-navbar-middle-text">Product</a>
            <a href="/about_us/about_us.php" class="sub-navbar-middle-text">About Us</a>
            <a href="#" class="sub-navbar-middle-text" style="color: #FFC700;">Profile</a>
            <a href="#" class="sub-navbar-middle-text">Login</a>
        </div>
        <!-- Profile Content -->
        <div class="main-container">
            <!-- Top Bar -->
            <div class="top-container">
                <span class="profile-text">Profile</span>
                <button class="logout-button"><a href="/authentication/logout.php">Log Out</a></button>
            </div>
            <hr>
            <!-- Content -->
            <div class="content-container">
                <!-- Left inforamtion and menu -->
                <div class="left-container">
                    <div class="user-info-container">
                        <div class='avatar'>
                            <?php
                            $firstLetter = substr($_SESSION['currentUser'], 0, 1);
                            echo "<span class='avatar-text'>{$firstLetter}</span>";
                            ?>
                        </div>
                        <?php
                        require_once "../config/database.php";
                        $sql = "SELECT * FROM users WHERE Username ='{$_SESSION['currentUser']}'";
                        $result = mysqli_query($conn, $sql);

                        if ($row = mysqli_fetch_assoc($result)) {
                            echo "<span class='username-text'>{$row['Username']}</span>";
                            echo "<span class='email-text-1'>{$row['Email']}</span>";
                        }
                        ?>
                    </div>
                    <div onclick="ShowMobileMenu()" class="burger-tag-container">
                        <svg class="burger-tag" xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: msFilter;">
                            <path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"></path>
                        </svg>
                    </div>
                    <div id="mobile-menu-container" style="transform: translateX(-100%);">
                        <span onclick="Back('pi')" id="mobile-menu-text-1" style="background-color: #FFFFFF; color: #232323;">Personal Information</span>
                        <span onclick="Back('oh')" id="mobile-menu-text-3" style="background-color: #232323; color: #FFFFFF;">Order History</span>
                        <span onclick="Back('fp')" id="mobile-menu-text-3" style="background-color: #232323; color: #FFFFFF;">Favourite Product</span>
                    </div>
                    <div class="menu-container">
                        <span onclick="Back('pi')" id="menu-text-1" style="color: #387D6B;">Personal
                            Information</span>
                        <span onclick="Back('oh')" id="menu-text-3" style="color: #000000;">Order History</span>
                        <span onclick="MenuDisplay('fp')" id="menu-text-4" style="color: #000000;">Favourite
                            Product</span>
                    </div>
                </div>
                <!-- Right inforamtion display -->
                <div class="right-container">
                    <div id="right-container-personal-information" style="display:block;">
                        <div class="right-container-top-text">
                            <span class="right-container-top-text-main">Personal Information</span>
                            <span class="right-container-top-text-sub">Manage your information, including name, email
                                address.</span>
                        </div>
                        <div class="cards-container">
                            <div class="card">
                                <div class="card-first">
                                    <span class="username-text">Username</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24" style="fill: rgba(49, 94, 82, 1);transform: msFilter;">
                                        <path d="M12 2A10.13 10.13 0 0 0 2 12a10 10 0 0 0 4 7.92V20h.1a9.7 9.7 0 0 0 11.8 0h.1v-.08A10 10 0 0 0 22 12 10.13 10.13 0 0 0 12 2zM8.07 18.93A3 3 0 0 1 11 16.57h2a3 3 0 0 1 2.93 2.36 7.75 7.75 0 0 1-7.86 0zm9.54-1.29A5 5 0 0 0 13 14.57h-2a5 5 0 0 0-4.61 3.07A8 8 0 0 1 4 12a8.1 8.1 0 0 1 8-8 8.1 8.1 0 0 1 8 8 8 8 0 0 1-2.39 5.64z">
                                        </path>
                                        <path d="M12 6a3.91 3.91 0 0 0-4 4 3.91 3.91 0 0 0 4 4 3.91 3.91 0 0 0 4-4 3.91 3.91 0 0 0-4-4zm0 6a1.91 1.91 0 0 1-2-2 1.91 1.91 0 0 1 2-2 1.91 1.91 0 0 1 2 2 1.91 1.91 0 0 1-2 2z">
                                        </path>
                                    </svg>
                                </div>
                                <?php
                                require_once "../config/database.php";
                                $sql = "SELECT * FROM users WHERE Username ='{$_SESSION['currentUser']}'";
                                $result = mysqli_query($conn, $sql);

                                if ($row = mysqli_fetch_assoc($result)) {
                                    echo "<span class='email-text'>{$row['Username']}</span>";
                                }
                                ?>
                            </div>
                            <div class="card">
                                <div class="card-first">
                                    <span class="username-text">Email Address</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24" style="fill: rgba(49, 94, 82, 1);transform: msFilter;">
                                        <path d="M20 4H4c-1.103 0-2 .897-2 2v12c0 1.103.897 2 2 2h16c1.103 0 2-.897 2-2V6c0-1.103-.897-2-2-2zm0 2v.511l-8 6.223-8-6.222V6h16zM4 18V9.044l7.386 5.745a.994.994 0 0 0 1.228 0L20 9.044 20.002 18H4z">
                                        </path>
                                    </svg>
                                </div>
                                <?php
                                require_once "../config/database.php";
                                $sql = "SELECT * FROM users WHERE Username ='{$_SESSION['currentUser']}'";
                                $result = mysqli_query($conn, $sql);

                                if ($row = mysqli_fetch_assoc($result)) {
                                    echo "<span class='email-text'>{$row['Email']}</span>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <!-- Bill Payment -->
                    <div id="right-container-bill-payment" style="display:none;">
                        <div class="right-container-top-text">
                            <span class="right-container-top-text-main">Bill Payment</span>
                            <span class="right-container-top-text-sub">Manage your information, including name, email
                                address.</span>
                        </div>
                    </div>
                    <!-- Order History -->
                    <div id="right-container-order-history" style="display:none;">
                        <div class="right-container-top-text">
                            <span class="right-container-top-text-main">Order History</span>
                            <span class="right-container-top-text-sub">Manage your information, including name, email
                                address.</span>
                        </div>
                        <div class=".order-history-container">
                            <div class="order-history-card">
                                <div class="order-detail-table">
                                    <table>
                                        <tr>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Color</th>
                                            <th>Size</th>
                                            <th>Price</th>
                                        </tr>

                                        <?php
                                        ini_set('display_errors', 1);
                                        error_reporting(E_ALL);
                                        require("../config/database.php");

                                        $currentOrderID = $_GET['id'];
                                        $viewOrderProductSQL = "SELECT * FROM orders WHERE OrderID='$currentOrderID'";
                                        $result = mysqli_query($conn, $viewOrderProductSQL);
                                        $orderProduct = array();
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $orderProduct[] = $row;
                                            }
                                            foreach ($orderProduct as $resOrderProduct) {
                                                $productName = $resOrderProduct['ProductName'];
                                                $imageSQL = "SELECT ImagePath FROM images WHERE ProductName = '$productName' LIMIT 1";
                                                $res2 = mysqli_query($conn, $imageSQL);
                                                $imagePath = '';

                                                if (mysqli_num_rows($res2) > 0) {
                                                    $image = mysqli_fetch_assoc($res2);
                                                    $imagePath = $image['ImagePath'];
                                                }
                                                echo
                                                "
                                                    <tr onclick='GoToProductDetail(\"" . $productName . "\")'>
                                                    <td>" . "<img src='$imagePath' alt='image' width='80'>" . "</td>
                                                    <td>" . $resOrderProduct["ProductName"] . "</td>
                                                    <td>" . $resOrderProduct["ProductColor"] . "</td>
                                                    <td>" . $resOrderProduct["ProductSize"] . "</td>
                                                    <td>" . $resOrderProduct["Amount"] . "</td>
                                                </tr>
                                                ";
                                            }
                                        }
                                        ?>
                                    </table>
                                </div>
                                <div class="order-detail-text">
                                    <?php
                                    ini_set('display_errors', 1);
                                    error_reporting(E_ALL);
                                    require("../config/database.php");

                                    $viewOrderSQL = "SELECT OrderID, address , GROUP_CONCAT(ProductName) as ProductNames, GROUP_CONCAT(BuyQuantity) as BuyQuantities, SUM(Amount) as TotalAmount, Username, OrderDate, paymentMethod, orderStatus
                        FROM orders WHERE OrderID='$currentOrderID'
                        GROUP BY OrderID, Username, OrderDate, paymentMethod, orderStatus";
                                    $resOrder = mysqli_query($conn, $viewOrderSQL);
                                    $orders = mysqli_fetch_assoc($resOrder);
                                    echo
                                    "
                                <div>
                                    <span>Create Date: </span> " . $orders["OrderDate"] . "
                                </div>
                                <div>
                                    <span>Username: </span> " . $orders["Username"] . "
                                </div>
                                <div>
                                    <span>Address: </span> " . $orders["address"] . "
                                </div>
                                <div>
                                    <span>Total Price: </span>    " . $orders["TotalAmount"] . "
                                </div>
                                <div>
                                    <span>Payment Method: </span>     " . $orders["paymentMethod"] . "
                                </div>
                                <div>
                                    <span>Status: </span>     " . $orders["orderStatus"] . "
                                </div>
                                ";
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Favourite -->
                    <div id="right-container-favourite" style="display:none;">
                        <div class="right-container-top-text">
                            <span class="right-container-top-text-main">Favourite Product</span>
                            <span class="right-container-top-text-sub">Here is you favourite, click and view the
                                product.</span>
                        </div>
                        <div class=".order-history-container">
                            <div class="order-history-card">
                                <table>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                    </tr>

                                    <?php
                                    ini_set('display_errors', 1);
                                    error_reporting(E_ALL);
                                    require("../config/database.php");
                                    $viewFavouriteProductSQL = "SELECT * FROM favourite WHERE Username ='{$_SESSION['currentUser']}'";
                                    $resFavouriteProduct = mysqli_query($conn, $viewFavouriteProductSQL);

                                    if ($resFavouriteProduct) { // Check if the result is not false
                                        if (mysqli_num_rows($resFavouriteProduct) > 0) {
                                            while ($favouriteProduct = mysqli_fetch_assoc($resFavouriteProduct)) {
                                                $viewProductSQL = "SELECT * FROM products WHERE ProductName = '{$favouriteProduct['ProductName']}'";
                                                $resProduct = mysqli_query($conn, $viewProductSQL);
                                                if ($resProduct) { // Check if the result is not false
                                                    if (mysqli_num_rows($resProduct) > 0) {
                                                        while ($product = mysqli_fetch_assoc($resProduct)) {
                                                            $productName = $product['ProductName'];
                                                            $imageSQL = "SELECT ImagePath FROM images WHERE ProductName = '$productName' LIMIT 1";
                                                            $res2 = mysqli_query($conn, $imageSQL);
                                                            $imagePath = '';

                                                            if (mysqli_num_rows($res2) > 0) {
                                                                $image = mysqli_fetch_assoc($res2);
                                                                $imagePath = $image['ImagePath'];
                                                            }
                                                            echo "
                                                            <tr onclick='GoToProductDetail(\"" . $productName . "\")'>
                                                                    <td><img src='" . $imagePath . "' width='80'></td>
                                                                    <td>" . $product["ProductName"] . "</td>
                                                                    <td>" . "$" . $product["ProductPrice"] . "</td>
                                                                </tr>
                                                                ";
                                                        }
                                                    }
                                                } else {
                                                    // Display the error message
                                                    echo "Error: " . mysqli_error($conn);
                                                }
                                            }
                                        }
                                    } else {
                                        // Display the error message
                                        echo "Error: " . mysqli_error($conn);
                                    }


                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<script>
    MenuDisplay("oh")

    function Back(link) {
        window.location.href = "profile.php";
    }

    function GoToProductDetail(name) {
        window.location.href = "/product/product_detail.php?name=" + name;
    }
</script>