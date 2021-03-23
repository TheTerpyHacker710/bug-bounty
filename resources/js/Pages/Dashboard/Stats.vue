<template>
    <div class="text-center px-4 py-4">
        <h1>Statistics</h1>
    </div>

    <div class="grid grid-rows-2 gap-4 px-4 py-2">
          
        <span class="px-4 py-4 border-4">
            <h2 class="text-center">Leaderboard</h2>
        </span>

        <span class="px-2 py-2 border-4">            
            <chart :chart="chart"/>
        </span>
    </div>   
</template>

<script>
import Chart from '@/Pages/Dashboard/Chart';

export default {
    props: ['chart'],

    components: {
        Chart    
    },

    data() {
        return {
            
        }
        
    }
}

</script>