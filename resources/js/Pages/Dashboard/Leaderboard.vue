<template>
    <h2 class="text-center">Leaderboard (Top 10)</h2>
        <div class="grid grid-cols-6 gap-2 px-2 py-2">
                
            <span class="col-span-1">
                <h2 class="text-center">Rank</h2>
                <div v-for="n in leaderboard.length" :key="n" class="text-center">
                    {{n}}
                </div>
            </span>

            <span class="col-span-3 text-center">
                <h2>Username</h2>
                <div v-for="position in leaderboard" :key="position.id">
                    {{position.username}}
                </div>
            </span>
            
            <span class="col-span-1">
                <h2>XP</h2>
                <div v-for="position in leaderboard" :key="position.id">
                    {{position.reputation}}
                </div>
            </span>

            <span class="col-span-1">
                <!-- NEED TO ADD FUNCTIONALITY TO COUNT THE AMOUNT OF AWARDS EACH USER HAS ON THE LEADERBOARD -->
                <h2>Awards</h2>
                <div v-for="position in leaderboard" :key="position.id">
                    {{position.reputation}}
                </div>
            </span>

        </div>
</template>

<script>
export default {
    props: ['leaderboard'],
}
</script>