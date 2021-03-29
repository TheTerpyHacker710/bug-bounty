<template>
    <home-nav-layout :canLogin="canLogin" :canRegister="canRegister"/>    
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