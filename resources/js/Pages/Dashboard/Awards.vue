<template>
    <div class="text-center px-4 py-4">
        <h2>Awards</h2>
    </div>

    <div class="grid grid-row-2 gap-4 px-1 py-1">
        <span class="px-4 py-4 border-4">
            <h2 class="text-center">Awards/Trophy's</h2>
        </span>

        <span class="px-4 py-4 border-4">
            <account-information :userInfo="userInfo"/>
        </span>
    </div>
    
</template>

<script>

import AccountInformation from './AccountInformation.vue';

export default {
    props: ['userInfo'],

    components: {
        AccountInformation,
    },
}

</script>