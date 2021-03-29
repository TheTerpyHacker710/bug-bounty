<template>
    <div class="min-h-screen bg-gray-100">
        <home-nav-layout :canLogin="canLogin" :canRegister="canRegister"/>
        <div class="container mx-auto h-auto lg:w-3/5 mt-10 bg-white rounded-lg shadow-xl">
            <div class="flex justify-center">
                <h2 class="text-2xl py-4 mt-5">Open Programs</h2>
            </div>

            <div class="container mx-auto h-auto w-4/5 mt-5 pb-8 bg-white rounded-lg">
                <div :key="program.id" v-for="program in programs" class="border rounded py-2 my-2">
                    <div class="relative flex flex-col justify-between lg:flex-row lg:items-center">
                        <h4 class="text-lg px-4 py-2">{{program.Title}}</h4>
                        <p class="px-4 py-4">{{program.Excerpt}}</p>
                        
                        <div class="px-1 flex flex-col justify-end lg:-my-px lg:mr-8 lg:ml-10 lg:flex-row lg:justify-center">
                            <inertia-link v-if="$page.props.user && activeReportPresent(program.id)" :href="route('JoinProgram')" method="post" :data="{user_id: $page.props.user.id, program_id: program.id }" class="no-underline text-center inline-block text-sm px-4 py-2 my-1 leading-none border rounded hover:border-transparent text-white bg-green-400 hover:bg-green-300 lg:mt-4 sm:mt-0">
                                Join
                            </inertia-link>
                            <inertia-link :href="route('home')" class="no-underline text-center inline-block text-sm px-4 py-2 my-1 lg:mr-2 lg:ml-2 leading-none border rounded hover:border-transparent text-white bg-blue-400 hover:bg-blue-300 lg:mt-4 sm:mt-0">
                                View
                            </inertia-link>

                            <inertia-link :href="route('home')" class="no-underline text-center inline-block text-sm px-4 py-2 my-1 leading-none border rounded hover:border-transparent text-white bg-blue-400 hover:bg-blue-300 lg:mt-4 sm:mt-0">
                                Contact
                            </inertia-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    </div>
</template>

<script>

import HomeNavLayout from "../Layouts/HomeNavLayout"

    export default {
        props: {
            canLogin: Boolean,
            canRegister: Boolean,
            programs: Array,
            activeReports: Array,
        },
        
        components: {
            HomeNavLayout,
        },

        methods: {
            activeReportPresent: function(program_id) {
                let isPresent = false;
                this.activeReports.forEach(function(activeReport){
                    if(activeReport.program_id === program_id) {
                        isPresent = true;
                    }
                });
                if(isPresent){
                    return false;
                }
                else {
                    return true;
                }
            }
        },
    }
</script>
