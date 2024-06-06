<?php include '../inc/header.php'; ?>


<body
    class="relative p-0 m-0 font-sans antialiased font-normal poppin sm:relative sm:overflow-x-hidden text-size-base leading-default dark:bg-vendor-secondary-beta bg-vendor-primary text-slate-500">
    <main
        class="relative block max-h-screen transition-all duration-200 ease-soft-in-out w-webkit w-moz h-cover rounded-xl"
        id="main">

        <?php include_once('includes/nav.php'); ?>

        <?php 
        if (isset($errors) || isset($error)) {
            echo($errors);
            echo($error);
        }
        
        ?>

        <div class="mx-auto w-full relative p-3">

            <div class="w-full container">

                <h1>
                    500! internal Server Error
                </h1>
            </div>

        </div>
    </main>

</body>

</html>