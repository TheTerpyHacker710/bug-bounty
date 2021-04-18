<template>
    <div class="min-h-screen bg-gray-100 md:pb-10">
        <home-nav-layout :canLogin="canLogin" :canRegister="canRegister"/>
        <div class="container flex flex-col justify-center mx-auto lg:w-3/5 md:mt-10 bg-white md:rounded-lg shadow-xl">
            <div class="flex justify-center">
                <h2 class="text-2xl py-4 mt-5">Contact Us</h2>
            </div>


            <div class="container flex flex-col justify-center mx-auto h-auto w-4/5 mt-5 pb-8 bg-white rounded-lg">
                <div class="flex justify-start">
                    <inertia-link :href="route('home')" class="no-underline text-center text-sm px-4 py-2 border rounded shadow-sm hover:border-transparent text-white bg-blue-400 hover:bg-blue-300 sm:mt-0">
                        <p> &lt;- Home</p>
                    </inertia-link>
                </div>
                <div class="border rounded shadow-md py-2 my-2 flex">
                    <div class="flex flex-col w-3/5 justify-start">
                        <form @submit.prevent="form.post('/contact/sendmail', {preserveScroll: true, onSuccess: () => form.reset(),})" novalidate="true">
                            <div class="flex flex-col">
                                <div class="flex flex-col justify-start py-4 px-2">
                                    <label class="text-md text-gray-700 uppercase font-bold" for="name">Full name:</label>
                                    <input type="text" name="name" v-model="form.name" placeholder="Enter your name..." class="shadow appearance-none border rounded w-full py-2 mb-3 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <div v-if="form.errors.name" class="text-red-600">Name is required</div>
                                </div>
                                <div class="flex flex-col justify-start py-4 px-2">
                                    <label class="text-md text-gray-700 uppercase font-bold" for="email">Email:</label>
                                    <input type="email" name="email" v-model="form.email" placeholder="Enter your email..." class="shadow appearance-none border rounded w-full py-2 mb-3 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <div v-if="form.errors.email" class="text-red-600">Email is required</div>
                                </div>
                                <div class="flex flex-col justify-start py-4 px-2">
                                    <label class="text-md text-gray-700 uppercase font-bold" for="message">Message:</label>
                                    <textarea name="message" v-model="form.message" placeholder="Enter your message..." class="shadow appearance-none border rounded w-full h-32 md:h-64 py-2 mb-3 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                                    <div v-if="form.errors.message" class="text-red-600">Message is required</div>
                                </div>
                            </div>
                            <div class="flex justify-end px-4">
                                <button type="submit" :disabled="form.processing" class="no-underline text-center text-sm px-4 py-2 border rounded shadow-sm hover:border-transparent text-white bg-green-400 hover:bg-green-300 sm:mt-0">
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="w-2/5 flex flex-col justify-center p-4">
                        <p class="py-8 text-gray-500">Please fill in the form on the left to contact one of the admin team. </p>
                        <p class="py-8 text-gray-500">Once the admin team has seen your message they will be in touch within 5 working days.</p>
                        <p class="py-8 text-gray-500">If you would like to contact a vendor please <inertia-link :href="route('ContactVendor')" class="no-underline hover:underline text-blue-500 hover:text-blue-600">click here</inertia-link></p> <!-- add in function for vendor contact -->
                    </div>
                </div>
            </div>
        </div>  
    </div>
</template>

<script>

import HomeNavLayout from "../Layouts/HomeNavLayout"
import { useForm } from '@inertiajs/inertia-vue3'

    export default {

        props: {
            'canLogin': Boolean,
            'canRegister': Boolean,
        },
        
        setup() {
            const form = useForm({
                name: null,
                email: null,
                message: null,
            })
            return { form }
        },
        
        components: {
            HomeNavLayout,
        },
    }
</script>
