<?php include('../../lib/db.php'); ?>
<?php include('../inc/header.php'); ?>
<?php


    $metrix = $conn->prepare("SELECT 
        (SELECT COUNT(*) FROM books) AS tbooks,
        (SELECT COUNT(*) FROM book_categories) AS tcates,
        (SELECT COUNT(*) FROM requests) AS treqs;
    ");
   $count = '';
    try { 
        $metrix->execute();
        $metrix->bind_result($tbooks, $tcates, $treqs);
        $count = $metrix->fetch();
        // var_dump($tbooks);
    } catch (\mysqli_sql_exception $e) {
        
        $response = 'Error ruuning multiple sqls: ' . $e->getMessage();
    } catch (\Exception $e) {
        $response = 'General error: ' . $e->getMessage();
    }  

    
?>

<body
    class="relative p-0 m-0 font-sans antialiased font-normal poppin sm:relative sm:overflow-x-hidden text-size-base leading-default dark:bg-vendor-secondary-beta bg-vendor-primary text-slate-500">
    <main
        class="relative block max-h-screen transition-all duration-200 ease-soft-in-out w-webkit w-moz h-cover rounded-xl"
        id="main">

        <?php include_once('../inc/topnav.php'); ?>

        <div class="flex pt-16 overflow-hidden bg-gray-50 dark:bg-gray-900">

            <?php include_once('../inc/sidebar.php') ?>

            <div class="fixed inset-0 z-10 hidden bg-gray-900/50 dark:bg-gray-900/90 " id="sidebarBackdrop"></div>

            <div id="main-content"
                class="relative w-full h-full overflow-y-auto bg-gray-50 lg:ml-64 ml-[256px] dark:bg-gray-900">
                <main>

                    <div class="grid grid-cols-1 px-4 pt-6 xl:grid-cols-3 xl:gap-4 dark:bg-gray-900">
                        <div class="mb-4 col-span-full xl:mb-2">
                            <nav class="flex mb-5" aria-label="Breadcrumb">
                                <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                                    <li class="inline-flex items-center">
                                        <a href="index.php"
                                            class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-primary-500">
                                            <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                                </path>
                                            </svg>
                                            Home
                                        </a>
                                    </li>
                                    <li>
                                        <div class="flex items-center">
                                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            <a href="#"
                                                class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-primary-500">Pages</a>
                                        </div>
                                    </li>

                                </ol>
                            </nav>
                            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Dashboard</h1>
                        </div>
                        <!-- Right Content -->
                        <div class="col-span-full flex gap-2 min-w-full">

                            <div class="p-4 mb-4 space-y-6 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800"
                                style="max-width: 24%">
                                <div
                                    class="px-4 py-2 text-gray-400 border border-gray-200 border-dashed rounded dark:border-gray-600">
                                    <h3>Total Books</h3>
                                </div>
                                <div
                                    class="h-32 px-4 py-2 text-gray-400 border border-gray-200 border-dashed rounded dark:border-gray-600">
                                    <h3><?php echo $tbooks;?></h3>
                                </div>
                                <div
                                    class="px-4 py-2 text-gray-400 border border-gray-200 border-dashed rounded dark:border-gray-600">
                                    <a href="books.php" class="">Books</a>
                                </div>
                            </div>

                            <div class="p-4 mb-4 space-y-6 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800"
                                style="max-width: 24%">
                                <div
                                    class="px-4 py-2 text-gray-400 border border-gray-200 border-dashed rounded dark:border-gray-600">
                                    <h3>Total Requests</h3>
                                </div>
                                <div
                                    class="h-32 px-4 py-2 text-gray-400 border border-gray-200 border-dashed rounded dark:border-gray-600">
                                    <h3><?php echo $treqs;?></h3>
                                </div>
                                <div
                                    class="px-4 py-2 text-gray-400 border border-gray-200 border-dashed rounded dark:border-gray-600">
                                    <a href="requests.php" class="">Requests</a>
                                </div>
                            </div>
                        </div>

                    </div>
            </div>

    </main>


    </div>

    </div>

    </main>

</body>

</html>