<template>
    <div>
        <jet-banner />

        <div class="bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="flex-shrink-0 flex items-center">
                                <inertia-link href="/">
                                    <h2>Website</h2>
                                </inertia-link>
                            </div>

                            <!-- Nav Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex items-center">
                                <jet-nav-link class="h-16" href="/about" :active="route().current('About')">
                                    About
                                </jet-nav-link>
                            </div>

                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex items-center">
                                <jet-nav-link class="h-16" href="/contact" :active="route().current('Contact')">
                                    Contact
                                </jet-nav-link>
                            </div>

                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex items-center">
                                <jet-nav-link class="h-16" href="/help" :active="route().current('Help')">
                                    Help
                                </jet-nav-link>
                            </div>
                        
                            <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
                                <div v-if="canLogin" class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                                    <inertia-link v-if="$page.props.user" href="/dashboard" class="no-underline inline-block text-sm px-4 py-2 leading-none border rounded hover:border-transparent hover:text-teal hover:bg-gray-300 mt-4 sm:mt-0">
                                        Dashboard
                                    </inertia-link>

                                    <template v-else>
                                        <inertia-link :href="route('login')" class="no-underline inline-block text-sm px-4 py-2 mr-2 leading-none border rounded hover:border-transparent hover:text-teal hover:bg-gray-300 mt-4 sm:mt-0">
                                            Log in
                                        </inertia-link>

                                        <inertia-link v-if="canRegister" :href="route('register')" class="no-underline inline-block text-sm px-4 py-2 leading-none border rounded hover:border-transparent hover:text-teal hover:bg-gray-300 mt-4 sm:mt-0">
                                            Register
                                        </inertia-link>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</template>

<script>
    import JetBanner from '@/Jetstream/Banner'
    import JetNavLink from '@/Jetstream/NavLink'

    export default {
        props: {
            canLogin: Boolean,
            canRegister: Boolean,
        },

        components: {
            JetBanner,
            JetNavLink,
        },

    }
</script>
