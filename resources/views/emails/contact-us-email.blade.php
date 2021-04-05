<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">
    <title>Email</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <div class="py-5">
        <div class="container mx-auto h-auto lg:w-3/5 bg-white md:rounded-lg shadow-xl">
            <div class="flex justify-center">
                <h2 class="text-2xl py-4 mt-5">Message Recieved from, {{$validData['name']}}</h2>
            </div>

            <div class="container mx-auto h-auto w-4/5 mt-5 pb-8 bg-white rounded-lg">
                <div class="border rounded py-2 my-2">
                    <p class="text-center p-4">{{$validData['message']}}</p>
                </div>
            </div>
        </div>  
    </div>
</body>
</html>