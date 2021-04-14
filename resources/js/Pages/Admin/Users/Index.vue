<!--Page once navigated to /admin/users-->

<template>
    <admin-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users
            </h2>
        </template>

<!--        Create user button-->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="my-5">
                <jet-button><a href="/admin/users/create" class="btn btn-primary">Create User</a></jet-button>
            </div>
        </div>

<!--        Table to display columns and rows of users and users details-->
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Organisation ID</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Organisation Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vendor</th>
                                    <th scope="col" class="relative px-6 py-3">Actions</th>
                                </tr>
                                </thead>

                                <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="user in users" :key="user.id">
                                    <td class="px-6 py-4 whitespace-nowrap">{{ user.name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ user.email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ user.username }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ user.org_id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ user.org_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ user.isVendor }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-indigo-600 hover:text-indigo-900">
<!--                                        Edit link to edit user (included in table)-->
                                    <inertia-link :href="`/admin/users/${user.id}/edit`">Edit</inertia-link>
                                    </td>
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
import AdminLayout from "../../../Layouts/AdminLayout";
import JetButton from '@/Jetstream/Button'

export default {
    props: ['users'],

    components: {
        AdminLayout,
        Welcome,
        JetButton,
    },
}
</script>
