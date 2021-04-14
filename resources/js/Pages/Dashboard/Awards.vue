<template>
    <div class="text-center px-4 py-4">
        <h2 class="text-xl md:text-2xl text-gray-700">Awards</h2>
    </div>

    <div class="grid grid-row-2 gap-4 px-1 py-1">
        <span class="px-4 py-4 border-4 rounded-lg ">
            <h2 class="text-center py-4 text-lg text-gray-600">Awards/Trophy's</h2>
            <div :key="badge.badge_id" v-for="badge in userBadges" class="border-t border-gray-500 py-2 my-2">
                <badges :badge="badge"/>
            </div>
        </span>

        <span class="px-4 py-4 border-4 rounded-lg">
            <account-information :userInfo="userInfo"/>
        </span>
    </div>
    
</template>

<script>

import AccountInformation from './AccountInformation.vue';
import Badges from '@/Pages/Dashboard/Badges';

export default {
    props: ['userInfo','userBadges'],

    components: {
        AccountInformation,
        Badges,
    },
}

</script>
