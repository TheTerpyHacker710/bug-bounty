<template>
    <div class="min-h-screen bg-gray-100 md:pb-10">
        <home-nav-layout :canLogin="canLogin" :canRegister="canRegister"/>
        <div class="container mx-auto h-auto lg:w-3/5 md:mt-10 bg-white md:rounded-lg shadow-xl">
            <div class="flex justify-center">
                <h2 class="text-2xl py-4 mt-5">Contact Us</h2>
            </div>


            <div class="container mx-auto h-auto w-4/5 mt-5 pb-8 bg-white rounded-lg">
                <div class="flex justify-start">
                    <inertia-link :href="route('home')" class="no-underline text-center text-sm px-4 py-2 border rounded hover:border-transparent text-white bg-blue-400 hover:bg-blue-300 sm:mt-0">
                        <p> &lt;- Home</p>
                    </inertia-link>
                </div>
                <div class="border rounded py-2 my-2">
                    <div class="flex flex-col">
                        <!-- Insert FORM to contact the admins of the site -->
                    </div>
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
        },
        
        components: {
            HomeNavLayout,
        },
    }
</script>
