<?php include '../../lib/db.php'; ?>
<?php include '../inc/header.php'; ?>

<?php if (isAdmin()) { ?>


<?php
    
    if (isset($_POST['save'])) {
        $title = $conn->real_escape_string($_POST['title']);
        $isbn = $conn->real_escape_string($_POST['isbn']);
        $author_id = $conn->real_escape_string($_POST['author']);
        $grant = $_POST['grant'] ?? null;
        $date = $_POST['date'];
        $category_id = $conn->real_escape_string($_POST['category']);

        // File upload handling
        if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] == 0) {
            $file_name = $_FILES['pdf']['name'];
            $file_tmp = $_FILES['pdf']['tmp_name'];
            $upload_dir = '../../assets/images/uploads/';
            $file_path = $upload_dir . basename($file_name);

            if (move_uploaded_file($file_tmp, $file_path)) {
                $pdf_path = $conn->real_escape_string($file_path);
                // Check if an image is uploaded
                $image_name = '';
                if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                    $image_name = $_FILES['image']['name'];
                    $image_tmp = $_FILES['image']['tmp_name'];
                    $image_upload_dir = '../../assets/images/uploads/';
                    $image_path = $image_upload_dir . basename($image_name);

                    // Move the image file to the upload directory
                    if (move_uploaded_file($image_tmp, $image_path)) {
                        $image_path = $conn->real_escape_string($image_path);
                    } else {
                        $image_path = NULL; // Set image path to NULL if no image uploaded
                    }
                } else {
                    $image_path = NULL; // Set image path to NULL if no image uploaded
                }

                $sql = "INSERT INTO books (title, isbn, file, publish_date, author_id, mockup, request_id, book_category_id) VALUES ('$title', '$isbn', '$pdf_path', '$date', '$author_id', '$image_path', '$grant', '$category_id')";

                if ($conn->query($sql) === TRUE) {
                    if ($grant != null) {
                        $req = $conn->prepare("UPDATE requests SET granted='granted' WHERE id='$grant';");
                        $req->execute();
                    }
                    
                    $response = "<p>Book added successfully!</p>";
                } else {
                    $response = "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
                }
            } else {
                $response ="<p>Failed to upload file.</p>";
            }
        } else {
            $response = "<p>No file uploaded or file upload error.</p>";
        }

        // Close connection
        // $conn->close();
    }

    if(isset($_POST['delete'])){
        $deleteId = $_POST['dbid'];
    
        $sql = $conn->prepare("DELETE FROM books WHERE books.id='$deleteId';");
        $sql->execute();
        $response = 'Book deleted successfully!';
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
                                <button type="button" id="toggleButton" data-model="Book"
                                    class="inline-flex items-center justify-center w-1/2 px-3 py-2 text-sm font-medium text-center text-white rounded-lg hover:bg-gradient-to-tl hover:from-vendor-secondary-beta bg-gradient-cyan hover:via-vendor-secondary-alpha hover:to-vendor-tertiary-beta focus:ring-4 focus:ring-primary-300 sm:w-auto dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                    <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span id="buttonText">Add Book</span>
                                </button>

                            </div>
                        </div>

















                        <div class="flex flex-col col-start-1 col-end-12">
                            <div class="overflow-x-auto">
                                <div class="inline-block w-full align-middle">
                                    <div class="overflow-hidden shadow px-4">
                                        <div>

                                            <?php if (isset($response)) {

                                            ?>
                                            <script>
                                            Swal.fire({
                                                title: "Success!",
                                                icon: 'success',
                                                text: "<?php echo $response; ?>"
                                            });
                                            </script>
                                            <?php
                                            // echo $response;
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
                                                        <a href="book_edit.php?bid=<?php echo $row['book_id']; ?>"
                                                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center  rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                                            <svg class="w-4 h-4 mr-2" fill="currentColor"
                                                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z">
                                                                </path>
                                                                <path fill-rule="evenodd"
                                                                    d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                                    clip-rule="evenodd"></path>
                                                            </svg>
                                                            Edit
                                                        </a>
                                                        <form action="" method="POST" id="deleteForm">
                                                            <input type="hidden" name="dbid" id="delete"
                                                                value="<?php echo $row['book_id']; ?>">
                                                            <button name="delete" type="submit" id="deletebtn"
                                                                onclick="return confirm('Are you sure yo wanna delete this?')"
                                                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center  bg-red-600 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900">
                                                                <svg class="w-4 h-4 mr-2" fill="currentColor"
                                                                    viewBox="0 0 20 20"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd"
                                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                        clip-rule="evenodd"></path>
                                                                </svg>
                                                                Delete
                                                            </button>
                                                        </form>
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
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category
                                                    Name</label>
                                                <input type="text" name="title" id="name"
                                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    placeholder="Molecular Physics" required="">
                                            </div>
                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="first-name"
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ISBN</label>
                                                <input type="text" name="isbn" id="isbn"
                                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    placeholder="ISBN" required="">
                                            </div>
                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="first-name"
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Publish
                                                    Date</label>
                                                <input type="date" name="date" id="isbn"
                                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    placeholder="ISBN" required="">
                                            </div>
                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="first-name"
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Book
                                                    file</label>
                                                <input type="file" name="pdf" id="pdf"
                                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    placeholder="Science" required="">
                                            </div>
                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="first-name"
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Book
                                                    Mockup</label>
                                                <input type="file" name="image" id="pdf"
                                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    placeholder="Science" required="">
                                            </div>

                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="first-name"
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Author</label>
                                                <select name="author" id="author"
                                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    placeholder="Science" required="">
                                                    <option value="">----</option>
                                                    <?php 
                                                    
                                                    $authors = "SELECT * FROM authors";
                                                    $res = $conn->query($authors);
                                                    while($author = $res->fetch_assoc()){
                                                    ?>
                                                    <option value="<?php echo $author['id']; ?>">
                                                        <?php echo $author['name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="first-name"
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">A
                                                    grant for request</label>
                                                <select name="grant" id="author"
                                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    placeholder="Science" required="">
                                                    <option value="">----</option>
                                                    <?php 
                                                    
                                                    $authors = "SELECT * FROM requests where granted='pending';";
                                                    $res = $conn->query($authors);
                                                    while($author = $res->fetch_assoc()){
                                                    ?>
                                                    <option value="<?php echo $author['id']; ?>">
                                                        <?php echo $author['bookname']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>


                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="first-name"
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
                                                <select name="category" id="author"
                                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    placeholder="Science" required="">
                                                    <option value="">----</option>
                                                    <?php 
                                                    
                                                    $cates = "SELECT * FROM book_categories";
                                                    $rez = $conn->query($cates);
                                                    while($cate = $rez->fetch_assoc()){
                                                    ?>
                                                    <option value="<?php echo $cate['id']; ?>">
                                                        <?php echo $cate['name']; ?></option>
                                                    <?php } ?>
                                                </select>
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
</body>

</html>






<?php } ?>