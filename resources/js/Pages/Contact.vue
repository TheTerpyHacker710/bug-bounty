<template>
    <div class="min-h-screen bg-gray-100 md:pb-10">
        <home-nav-layout :canLogin="canLogin" :canRegister="canRegister"/>
        <div class="container flex flex-col justify-center mx-auto lg:w-3/5 md:mt-10 bg-white md:rounded-lg shadow-xl">
            <div class="flex justify-center">
                <h2 class="text-2xl py-4 mt-5">Contact Us</h2>
            </div>


            <div class="container flex flex-col justify-center mx-auto h-auto w-4/5 mt-5 pb-8 bg-white rounded-lg">
                <div class="flex justify-start">
                    <inertia-link :href="route('home')" class="no-underline text-center text-sm px-4 py-2 border rounded hover:border-transparent text-white bg-blue-400 hover:bg-blue-300 sm:mt-0">
                        <p> &lt;- Home</p>
                    </inertia-link>
                </div>
                <div v-if="errors.length">
                    <div class="flex flex-col w-full">
                        <ul>
                            <li v-for="error in errors" :key="error" class="border border-red-400 bg-red-300 text-white p-2 rounded-lg my-2">{{ error }}</li>
                        </ul>
                    </div>
                </div>
                <div class="border rounded py-2 my-2 flex">
                    <div class="flex flex-col w-3/5 justify-start">
                        <form @submit.prevent="checkForm" novalidate="true">
                            <div class="flex flex-col">
                                <div class="flex flex-col justify-start py-4 px-2">
                                    <label class="text-md text-gray-700 uppercase font-bold" for="name">Full name:</label>
                                    <input type="text" name="name" v-model="StaticFormData.name" placeholder="Enter your name..." class="shadow appearance-none border rounded w-full py-2 mb-3 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                </div>
                                <div class="flex flex-col justify-start py-4 px-2">
                                    <label class="text-md text-gray-700 uppercase font-bold" for="email">Email:</label>
                                    <input type="email" name="email" v-model="StaticFormData.email" placeholder="Enter your email..." class="shadow appearance-none border rounded w-full py-2 mb-3 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                </div>
                                <div class="flex flex-col justify-start py-4 px-2">
                                    <label class="text-md text-gray-700 uppercase font-bold" for="message">Message:</label>
                                    <textarea name="message" v-model="StaticFormData.message" placeholder="Enter your message..." class="shadow appearance-none border rounded w-full py-2 mb-3 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                                </div>
                            </div>
                            <div class="flex justify-end px-4">
                                <button type="submit" class="no-underline text-center text-sm px-4 py-2 border rounded hover:border-transparent text-white bg-green-400 hover:bg-green-300 sm:mt-0">
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="w-2/5 flex flex-col justify-center p-4">
                        <p class="py-8 text-gray-500">Please fill in the form on the left to contact one of the admin team. </p>
                        <p class="py-8 text-gray-500">Once the admin team has seen your message they will be in touch within 5 working days.</p>
                        <p class="py-8 text-gray-500">If you want to contact a vendor please browse here</p> <!-- add in function for vendor contact -->
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
            'canLogin': Boolean,
            'canRegister': Boolean,
        },

        data() {
            return {
                errors: [],
                StaticFormData: {
                    name: "",
                    email: "",
                    message: "",
                }
            }
        },
        
        components: {
            HomeNavLayout,
        },

        methods: {
            checkForm: function(e) {
                this.errors = [];

                if(!this.StaticFormData.name) {
                    this.errors.push("Name is required");
                }
                if(!this.StaticFormData.email) {
                    this.errors.push("Email is required");
                }
                else if(!this.validEmail(this.StaticFormData.email)) {
                    this.errors.push('Valid email required')
                }
                if(!this.StaticFormData.message) {
                    this.errors.push("Message is required");
                }

                if(!this.errors.length) {
                    this.$inertia.post(route('SendMail'), this.StaticFormData);
                }

                e.preventDefault();
            },

            validEmail: function (email) {
                var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            }
        }
    }
</script>
