<template>
    <div>
        <jet-banner />
        <nav class="bg-white border-b border-gray-100 h-16">
            <!-- Primary Navigation Menu -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <!-- Logo -->
                        <div class="flex-shrink-0 flex items-center">
                            <inertia-link href="/">
                                <h2>Website</h2>
                            </inertia-link>
                        </div>

                        <!-- Nav Links -->
                        <div class="space-x-24 px-1 sm:-my-px sm:ml-10 sm:flex sm:items-center">
                            <jet-nav-link class="h-16" href="/about" :active="route().current('About')">
                                About
                            </jet-nav-link>
                        </div>

                        <div class="space-x-24 px-1 sm:-my-px sm:ml-10 sm:flex sm:items-center">
                            <jet-nav-link class="h-16" href="/contact" :active="route().current('Contact')">
                                Contact
                            </jet-nav-link>
                        </div>

                        <div class="space-x-24 px-1 sm:-my-px sm:ml-10 sm:flex sm:items-center">
                            <jet-nav-link class="h-16" href="/help" :active="route().current('Help')">
                                Help
                            </jet-nav-link>
                        </div>
                    
                        
                        <div v-if="canLogin" class="absolute right-0 mr-8 px-1 sm:-my-px sm:ml-10 sm:flex sm:items-center">
                            <inertia-link v-if="$page.props.user" href="/dashboard" class="no-underline inline-block text-sm px-4 py-2 leading-none border rounded hover:border-transparent hover:text-teal hover:bg-gray-100 mt-4 sm:mt-0">
                                Dashboard
                            </inertia-link>

                            <template v-else>
                                <inertia-link :href="route('login')" class="no-underline inline-block text-sm px-4 py-2 mr-2 leading-none border rounded hover:border-transparent hover:text-teal hover:bg-gray-100 mt-4 sm:mt-0">
                                    Log in
                                </inertia-link>

                                <inertia-link v-if="canRegister" :href="route('register')" class="no-underline inline-block text-sm px-4 py-2 leading-none border rounded hover:border-transparent hover:text-teal hover:bg-gray-100 mt-4 sm:mt-0">
                                    Register
                                </inertia-link>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
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
