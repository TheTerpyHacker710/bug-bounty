<template>
    <home-nav-layout :canLogin="canLogin" :canRegister="canRegister"/>
    <h2>Hello World</h2>
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
