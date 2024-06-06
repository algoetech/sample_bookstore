<?php 
include 'lib/db.php';


if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($password == $_POST['confirm']) {
        $sql = "INSERT INTO users (username, email, password) values(?, ?, ?)";
        if ($stmt = $conn->prepare($sql)) {
        
            $hash = password_hash($password, PASSWORD_ARGON2ID);
            
            $stmt->bind_param("sss", $name, $email, $hash);
            
            
            
            if ($stmt->execute()) {
                $sql = "SELECT users.*, roles.id as rid, roles.name as role FROM users JOIN roles ON users.role_id = roles.id WHERE users.email = ?";
                $stmt = $conn->prepare($sql);
        
                $stmt->bind_param("s", $email);
                
                $stmt->execute();
                $res = $stmt->get_result();
                $user = $res->fetch_assoc();
                if ($user) {
                    session_start();
                    
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_role'] = $user['role'];
                    $_SESSION['user_role_id'] = $user['rid'];
                    
                    header("Location: OAuth/".$_SESSION['user_role']."/index.php");
                    exit();
                } else {
                    $error_message = "Invalid password. Please try again.";
                }
            } else {
                $error_message = "Registration Failed. Please try again.";
            }
            
            // $stmt->close();
        } else {
            $error_message = "An error occurred. Please try again later.";
        }
    }else{
        $error_message = "An error occurred. Your password do not match.";
    }
        
    // echo password_hash($_POST['password'], PASSWORD_ARGON2ID);


    
    
    
    
    // $conn->close();
}

?>

<?php include 'includes/header.php'; ?>

<body
    class="relative p-0 m-0 font-sans antialiased font-normal poppin sm:relative sm:overflow-x-hidden text-size-base leading-default dark:bg-vendor-secondary-beta bg-vendor-primary text-slate-500"
    style="">

    <main
        class="relative block max-h-screen transition-all duration-200 ease-soft-in-out w-webkit w-moz h-cover rounded-xl"
        id="main">

        <?php include_once('includes/nav.php'); ?>

        <div class="mx-auto lg:max-w-[67%] w-full relative p-3">


            <form class="max-w-[70%] rounded-2 py-20 px-30 mx-auto shadow-soft-2xl mt-8 bg-slate-200/50" method="POST"
                action="" enctype="multipart/form-data">
                <?php
                if (isset($error_message)) { ?>

                <div class="w-full" style="color: #8a343f; padding-bottom: 5px;"> <?php echo $error_message; ?></div>
                <?php } ?>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="name" id="Name"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder="" required="">
                    <label for="Email"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Full
                        Name</label>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="email" name="email" id="Email"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" " required="">
                    <label for="Email"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email
                        address</label>
                </div>

                <div class="relative z-0 w-full mb-5 group">
                    <input type="password" name="password" id="password"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" " required="">
                    <label for="password"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Password</label>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="password" name="confirm" id="password"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" " required="">
                    <label for="password"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Confirm
                        Password</label>
                </div>

                <button type="submit" name="register"
                    class="text-white relative w-full hover:bg-gradient-to-tl hover:from-vendor-secondary-beta hover:via-vendor-secondary-alpha hover:to-vendor-tertiary-beta transition-none ease-soft-in-out hover:scale-[102%] bg-gradient-cyan my-4 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm  px-5 py-2.5 text-center ">Register</button>
            </form>

        </div>
    </main>
</body>

</html>