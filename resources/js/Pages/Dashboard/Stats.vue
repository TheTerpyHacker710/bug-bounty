<template>
    <div class="text-center px-4 py-4">
        <h1 class="text-xl md:text-2xl">Statistics</h1>
    </div>

    <div class="grid grid-rows-2 gap-4 px-4 py-2">
          
        <span class="px-4 py-4 border-4 rounded-lg">
            <leaderboard :leaderboard="leaderboard"/>
        </span>

        <span class="px-2 py-2 border-4 rounded-lg">            
            <chart :chart="chart"/>
        </span>
    </div>   
</template>

<script>
import Chart from '@/Pages/Dashboard/Chart';
import Leaderboard from '@/Pages/Dashboard/Leaderboard';

export default {
    props: ['chart', 'leaderboard'],

    components: {
        Chart,
        Leaderboard,
    },

    data() {
        return {
            
        }
        
    }
}

</script>