<template>
    <div class="min-h-screen bg-gray-100 md:pb-10">
        <home-nav-layout :canLogin="canLogin" :canRegister="canRegister"/>
        <div class="container mx-auto h-auto lg:w-3/5 md:mt-10 bg-white md:rounded-lg shadow-xl">
            <div class="flex justify-center">
                <h2 class="text-2xl py-4 mt-5">About</h2>
            </div>


            <div class="container mx-auto h-auto w-4/5 mt-5 pb-8 bg-white rounded-lg">
                <div class="flex justify-start">
                    <inertia-link :href="route('home')" class="no-underline text-center text-sm px-4 py-2 border rounded hover:border-transparent text-white bg-blue-400 hover:bg-blue-300 sm:mt-0">
                        <p> &lt;- Home</p>
                    </inertia-link>
                </div>
                <div class="border rounded py-2 my-2">
                    <p class="text-center p-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec elementum leo tincidunt ex accumsan ornare. Quisque vulputate lacus ac lectus condimentum suscipit. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vivamus sagittis aliquet sem nec ornare. Nullam pretium diam velit, at mollis nulla gravida non. Aenean vehicula magna a erat fringilla semper. Nullam ultricies dignissim convallis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Aliquam neque diam, cursus at felis non, vehicula ornare risus. Phasellus finibus ultrices dui. Quisque laoreet lectus lobortis, fermentum dolor eu, faucibus sem. Suspendisse molestie mollis diam, eget aliquam mi tempus vitae. Praesent ultricies eu enim ut sagittis. Nam eu eros dapibus, ultrices nibh non, tristique sapien. Nullam sed elit nulla. Vivamus suscipit interdum lorem vel lobortis. <br>Sed sit amet erat eu enim volutpat fermentum. Vestibulum eget semper sem. Aliquam et quam ac leo condimentum sagittis nec vel ipsum. Ut ut metus velit. Quisque hendrerit porta mi id fermentum. Quisque mollis sapien sapien. Integer in metus sit amet augue imperdiet pellentesque. Morbi ut varius odio. Sed tempor, justo id elementum ornare, nisl odio lobortis dolor, a auctor purus est eu ante. Morbi convallis dolor sit amet odio bibendum, eu pellentesque lectus iaculis. Curabitur eu consequat felis, eget feugiat felis. Nunc id vestibulum massa. <br>Donec fringilla quam sit amet orci ornare, vel porta tortor placerat. Morbi mattis enim mauris, vitae porttitor mi blandit sit amet. Duis in est nec elit convallis lobortis. Pellentesque libero urna, rhoncus eget purus sed, facilisis tempus nisi. Aliquam in leo ac dolor suscipit malesuada. Suspendisse ornare ligula turpis, ac tincidunt sem ullamcorper sed. Aenean interdum sit amet libero quis pharetra. Aenean pellentesque mauris pharetra, imperdiet quam ut, rutrum dolor.  </p>
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
