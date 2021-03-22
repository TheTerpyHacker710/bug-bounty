<template>
    <div class="text-center px-4 py-4">
        <h1>Statistics</h1>
    </div>

    <div class="grid grid-rows-2 gap-4 px-4 py-2">
          
        <span class="px-4 py-4 border-4">
            <h2 class="text-center">Leaderboard (Top 10)</h2>
            <div class="grid grid-cols-6 gap-2 px-2 py-2">
                
                <span class="col-span-1">
                    Rank
                    <div v-for="n in leaderboard.length" :key="n">
                        {{n}}
                    </div>
                </span>

                <span class="col-span-3 text-center">
                    Username
                    <div v-for="position in leaderboard" :key="position.id">
                        {{position.username}}
                    </div>
                </span>
            
                <span class="col-span-1">
                    XP
                    <div v-for="position in leaderboard" :key="position.id">
                        {{position.reputation}}
                    </div>
                </span>

                <span class="col-span-1">
                    Awards
                    <div v-for="position in leaderboard" :key="position.id">
                        {{position.reputation}}
                    </div>
                </span>

            </div>
        </span>

        <span class="px-2 py-2 border-4">            
            <chart :chart="chart"/>
        </span>
    </div>   
</template>

<script>
import Chart from '@/Pages/Dashboard/Chart';

export default {
    props: ['chart', 'leaderboard'],

    components: {
        Chart    
    },

    data() {
        return {
            
        }
        
    }
}

</script>