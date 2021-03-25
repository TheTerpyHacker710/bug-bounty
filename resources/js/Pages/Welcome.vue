<template>
    <home-nav-layout :canLogin="canLogin" :canRegister="canRegister"/>
    <div class="min-h-screen bg-gray-100">
        <h2>Hello World</h2>
    </div>
</template>

<script>

import HomeNavLayout from "../Layouts/HomeNavLayout"

    export default {
        props: {
            canLogin: Boolean,
            canRegister: Boolean,
        },
        
        components: {
            HomeNavLayout,
        },
    }
</script>
