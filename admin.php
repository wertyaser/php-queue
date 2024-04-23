<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/output.css" />
    <title>Document</title>
</head>

<body class="bg-blue-300 min-h-screen">
    <main class="mx-auto w-11/12 max-w-7xl h-full pb-16">
        <div class="flex justify-between pt-24 mb-10">
            <h1 class="text-pink font-display text-5xl" data-aos="fade-right">Admin</h1>
            <div class="flex gap-3">
                <button class="p-3 bg-pink text-white rounded-md border border-white font-md shadow-md px-6"><a
                        href="add-user.php">ADD USER</a></button>
                <button class="p-3 bg-pink text-white rounded-md border border-white font-md shadow-md px-6"><a
                        href="logout.php">LOG OUT</a></button>
            </div>
        </div>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg " data-aos="flip-up">
            <table class="w-full text-xl text-left ">
                <thead class="text-xl text-white uppercase bg-pink ">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Trans. Type
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Date
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Duration
                        </th>
                        <th scope="col" class="px-6 py-3">

                        </th>
                    </tr>
                </thead>
    </main>
</body>

</html>