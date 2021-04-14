<!--Page once navigated to /admin/dashboard -->
<template>
    <admin-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Admin Dashboard
            </h2>
        </template>

<!--        Table to view all vendor requests-->
        <div class="grid grid-cols-1 gap-4 px-1 py-1 h-auto text-center py-2">
            <h2>Vendor Appeals</h2>
        </div>
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User ID</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vendor</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Approve</th>
                                    </tr>
                                </thead>

                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="data in vendor_requests" :key="data.id">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ data.user_id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ data.approved }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ data.created_at }}</td>
<!--                                        Button to approve vendor request-->
                                        <td class="px-6 py-4 whitespace-nowrap"><jet-button @click="approve(data.user_id)">Approve</jet-button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </admin-layout>
</template>

<script>
    import Welcome from '@/Jetstream/Welcome'
    import AdminLayout from "../../Layouts/AdminLayout";
    import AdminActiveJobs from "../Admin/AdminActiveJobs";
    import JetButton from "@/Jetstream/Button";

    export default {

        props: ['vendor_requests'],

        components: {
            AdminLayout,
            Welcome,
            AdminActiveJobs,
            JetButton
        },

        // Set variable to empty
        data() {
            return {
                form: this.$inertia.form({
                    user_id: '',

                }),
            }
        },

        methods: {
            // Method that calls approve function
            approve(user_id) {

                this.form.user_id = user_id;
                this.form.post('/approve');
            }

        }

    }
</script>
