<template>
    <h2 class="text-center text-lg text-gray-600">Leaderboard (Top 10)</h2>
        <div class="grid grid-cols-6 px-2 py-2">
                
            <span class="col-span-1 lg:hidden xl:block">
                <h2 class="text-center">Rank</h2>
                <div v-for="n in leaderboard.length" :key="n" class="text-center py-3 border-t border-b">
                    {{n}}
                </div>
            </span>

            <span class="col-span-3  text-center ">
                <h2>Username</h2>
                <div v-for="position in leaderboard" :key="position.id" class="text-center py-3 border-t border-b">
                    {{position.username}}
                </div>
            </span>
            
            <span class="col-span-1 lg:col-span-3 xl:col-span-1 text-center lg:text-right xl:text-center">
                <h2>XP</h2>
                <div v-for="position in leaderboard" :key="position.id" class="text-center lg:text-right xl:text-center py-3 border-t border-b">
                    {{position.reputation}}
                </div>
            </span>

            <span class="col-span-1 text-center lg:hidden xl:block">
                <!-- NEED TO ADD FUNCTIONALITY TO COUNT THE AMOUNT OF AWARDS EACH USER HAS ON THE LEADERBOARD -->
                <h2>Awards</h2>
                <div v-for="position in leaderboard" :key="position.id" class="text-center py-3 border-t border-b">
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