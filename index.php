<?php include 'includes/header.php'; ?>
<?php include 'lib/db.php'; ?>
<?php
$sql = $conn->prepare("SELECT books.id, books.title, books.mockup, book_categories.name as category, authors.name as author FROM books LEFT JOIN book_categories ON books.book_category_id = book_categories.id LEFT JOIN authors ON books.author_id=authors.id;");

try { 
    $sql->execute();
    $sql->bind_result($id, $title, $mockup, $category, $author);
    $results = [];
    while ($sql->fetch()) {
        $results[] = [
            'id' => $id,
            'title' => $title,
            'mockup' => $mockup,
            'category' => $category,
            'author' => $author
        ];
    }
} catch (\mysqli_sql_exception $e) {
    
    $response = 'Error ruuning multiple sqls: ' . $e->getMessage();
} catch (\Exception $e) {
    $response = 'General error: ' . $e->getMessage();
}


?>

<body
    class="relative p-0 m-0 font-sans antialiased font-normal poppin sm:relative sm:overflow-x-hidden text-size-base leading-default dark:bg-vendor-secondary-beta bg-vendor-primary text-slate-500"
    style="">

    <main
        class="relative block max-h-screen transition-all duration-200 ease-soft-in-out w-webkit w-moz h-cover rounded-xl"
        id="main">

        <?php include_once('includes/nav.php'); ?>

        <div class="mx-auto w-full relative p-3">

            <div class="w-full container">
                <div class="flex flex-row gap-2 flex-wrap">
                    <?php if (!empty($results)) {?>
                    <?php foreach($results as $res) {?>
                    <!-- card -->
                    <div
                        class="card relative w-full lg:max-w-[32.5%] md:max-w-[50%] kiswaswadu:w-full shadow-soft-xl rounded-3 p-3">
                        <div class="card-header">
                            <h2>Name: <?php echo htmlspecialchars($res['title']); ?></h2>
                        </div>
                        <a href="login.php">
                            <div class="card-body overflow-hidden relative grid w-full">
                                <img src="<?php if($res['mockup']!="") {echo str_replace("../../", "", $res['mockup']);}else{ echo "assets/images/logo.png"; } ?>"
                                    class="w-100 hover:scale-102" alt="<?php echo htmlspecialchars($res['title']); ?>">
                                <div class="absolute btn">
                                    Read
                                </div>
                            </div>
                        </a>
                        <div class="card-footer">
                            <?php echo htmlspecialchars($res['author']); ?>
                        </div>
                    </div>
                    <?php }?>
                    <?php }else{ echo "No Books founded!";}?>

                </div>
            </div>

        </div>
    </main>
</body>

</html>