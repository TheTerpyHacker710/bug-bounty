<template>
    <div class="min-h-screen bg-gray-100 md:pb-10">
        <home-nav-layout :canLogin="canLogin" :canRegister="canRegister"/>
        <div class="container mx-auto h-auto lg:w-3/5 md:mt-10 bg-white md:rounded-lg shadow-xl">
            <div class="flex justify-center">
                <h2 class="text-2xl py-4 mt-5">{{program.Title}}</h2>
            </div>

            <div class="container mx-auto h-auto w-4/5 mt-5 pb-8 bg-white rounded-lg">
                <div class="border rounded py-2 my-2">
                    <p class="text-center p-4">{{program.Description}}</p>
                </div>
            </div>
        </div>  
    </div>
</template>

<script>

import HomeNavLayout from "../Layouts/HomeNavLayout"

    export default {

        props: {
            'canLogin': Boolean,
            'canRegister': Boolean,
            'program': Object,
        },
        
        components: {
            HomeNavLayout,
        },
    }
</script>
