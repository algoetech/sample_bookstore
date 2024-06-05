<?php include('../../lib/db.php'); ?>
<?php include('../inc/header.php'); ?>


<?php
if (isset($_POST['save'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $author = $conn->real_escape_string($_POST['author']);
    $user = $_SESSION['user_id'];

    $sql = "INSERT INTO requests (bookname, author, user) VALUES ('$title','$author', '$user')";

    if ($conn->query($sql) === TRUE) {
        $response = "<p>Request sent successfully!</p>";
    } else {
        $response = "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }

}

?>

<?php 
    
    $sql = "SELECT books.id AS book_id, books.title, books.publish_date, authors.id AS author_id, authors.name AS author_name,
    book_categories.id AS category_id, book_categories.name AS category_name FROM books JOIN authors ON books.author_id =
    authors.id JOIN book_categories ON books.book_category_id = book_categories.id";

    // Execute the query
    $result = $conn->query($sql);    
    
    
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


                    <div class="flex flex-col pt-3 px-5">
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
                                                class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-primary-500">Books</a>
                                        </div>
                                    </li>

                                </ol>
                            </nav>
                            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Books</h1>
                        </div>
                        <!-- Right Content -->














                        <div class="sm:flex">
                            <div
                                class="items-center hidden mb-3 sm:flex sm:divide-x sm:divide-gray-100 sm:mb-0 dark:divide-gray-700">
                                <form class="lg:pr-3 hidden" action="#" method="GET">
                                    <label for="users-search" class="sr-only">Search</label>
                                    <div class="relative mt-1 lg:w-64 xl:w-96">
                                        <input type="text" name="email" id="users-search"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                            placeholder="Search for users">
                                    </div>
                                </form>
                                <div class="flex pl-0 mt-3 space-x-1 hidden sm:pl-2 sm:mt-0">
                                    <a href="#"
                                        class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </a>
                                    <a href="#"
                                        class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </a>
                                    <a href="#"
                                        class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </a>
                                    <a href="#"
                                        class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z">
                                            </path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <div class="flex items-center ml-auto space-x-2 sm:space-x-3">
                                <button type="button" id="toggleButton" data-model="Book req"
                                    class="inline-flex items-center justify-center w-1/2 px-3 py-2 text-sm font-medium text-center text-white rounded-lg hover:bg-gradient-to-tl hover:from-vendor-secondary-beta bg-gradient-cyan hover:via-vendor-secondary-alpha hover:to-vendor-tertiary-beta focus:ring-4 focus:ring-primary-300 sm:w-auto dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                    <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span id="buttonText">Add Book Req</span>
                                </button>

                            </div>
                        </div>

















                        <div class="flex flex-col col-start-1 col-end-12">
                            <div class="overflow-x-auto">
                                <div class="inline-block w-full align-middle">
                                    <div class="overflow-hidden shadow px-4">
                                        <div>

                                            <?php if (isset($response)) {
                                                echo $response;
                                            } ?>

                                        </div>


                                        <?php if ($result->num_rows > 0) { ?>


                                        <table id="list"
                                            class="w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                                            <thead class="bg-gray-100 dark:bg-gray-700">
                                                <th scope="col"
                                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                                    #
                                                </th>

                                                <th scope="col"
                                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                                    Book Name
                                                </th>
                                                <th scope="col"
                                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                                    Author
                                                </th>
                                                <th scope="col"
                                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                                    Category
                                                </th>
                                                <th scope="col"
                                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                                    Publish Date
                                                </th>

                                                <th scope="col"
                                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                                    Actions
                                                </th>
                                                </tr>
                                            </thead>
                                            <tbody
                                                class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                                <?php $count = 0; while ($row = $result->fetch_assoc()) { $count++;?>
                                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                                    <td
                                                        class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                        <?php echo $count; ?></td>
                                                    <td
                                                        class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                        <?php echo $row['title']; ?></td>


                                                    <td
                                                        class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                        <?php echo $row['author_name']; ?></td>
                                                    <td
                                                        class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                        <?php echo $row['category_name']; ?></td>
                                                    <td
                                                        class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                        <?php echo $row['publish_date']; ?></td>

                                                    <td class="p-4 space-x-2 whitespace-nowrap">
                                                        <button type="button"
                                                            class="read-button inline-flex items-center px-3 py-2 text-sm font-medium text-center rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                                                            data-id="<?php echo $row['book_id']; ?>">
                                                            <svg class="w-4 h-4 mr-2" fill="currentColor"
                                                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z">
                                                                </path>
                                                                <path fill-rule="evenodd"
                                                                    d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                                    clip-rule="evenodd"></path>
                                                            </svg>
                                                            Read
                                                        </button>
                                                        <button type="button"
                                                            class="download-button inline-flex items-center px-3 py-2 text-sm font-medium text-center bg-red-600 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900"
                                                            data-id="<?php echo $row['book_id']; ?>">
                                                            <svg class="w-4 h-4 mr-2" fill="currentColor"
                                                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd"
                                                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                    clip-rule="evenodd"></path>
                                                            </svg>
                                                            Download
                                                        </button>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>


                                        <?php }else{echo "No Book added yet";} ?>

                                        <form action="" class="add hidden" id="add" method="POST"
                                            enctype="multipart/form-data">
                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="first-name"
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
                                                <input type="text" name="title" id="name"
                                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    placeholder="Molecular Physics" required="">
                                            </div>
                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="first-name"
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Author</label>
                                                <input type="text" name="author" id="isbn"
                                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    placeholder="ISBN" required="">
                                            </div>









                                            <button type="submit" name="save"
                                                class="text-white relative w-full hover:bg-gradient-to-tl hover:from-vendor-secondary-beta hover:via-vendor-secondary-alpha hover:to-vendor-tertiary-beta transition-none ease-soft-in-out hover:scale-[102%] bg-gradient-cyan my-4 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm  px-5 py-2.5 text-center ">
                                                Save</button>


                                        </form>


                                    </div>
                                </div>
                            </div>
                        </div>






































                    </div>

                </main>


            </div>

        </div>

    </main>

    <script src="../../assets/js/app.js">
    </script>
    <script type="module">
    $('.read-button').on('click', function() {
        var bookId = $(this).data('id');
        // Perform AJAX request to fetch book path
        $.ajax({
            type: 'POST',
            url: 'book_show.php',
            dataType: 'json',
            data: {
                id: bookId
            },
            success: function(response) {
                console.log(response);
                // Assuming response contains the book path
                var bookPath = response.book_path;
                console.log(response.book_path);
                // Open the PDF in a new window or iframe
                Swal.fire({
                    title: 'Read Book',
                    html: '<iframe src="' + bookPath +
                        '" width="100%" height="600px"></iframe>',
                    width: '80%',
                    padding: '3em',
                    showConfirmButton: false
                });
            },
            error: function(xhr, status, error) {
                Swal.fire(
                    'Error!',
                    'An error occurred while trying to read the book.',
                    'error'
                );
            }
        });
    });

    // Handle Download button click
    $('.download-button').on('click', function() {
        console.log('clicked');
        var bookId = $(this).data('id');
        // Perform AJAX request to fetch book path
        $.ajax({
            type: 'POST',
            url: 'book_show.php',
            dataType: 'json',
            data: {
                id: bookId
            },
            success: function(response) {
                // Assuming response contains the book path
                var bookPath = response.book_path;
                console.log(response);
                // Trigger file download
                window.location.href = bookPath;
            },
            error: function(xhr, status, error) {
                Swal.fire(
                    'Error!',
                    'An error occurred while trying to download the book.',
                    'error'
                );
            }
        });
    });
    </script>
</body>

</html>