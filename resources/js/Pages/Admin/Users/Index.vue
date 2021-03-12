<!--Page once navigated to /users-->

<template>
    <admin-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users
            </h2>
        </template>

        <div class="py-3">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    List of Users
                </div>
            </div>
        </div>

        <div v-if="successMessage" class="alert alert-success mt-4">
            {{ successMessage }}
        </div>

        <div class="py-3">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="my-5">
                        <a href="/admin/users/create" class="btn btn-primary">Create User</a>
                    </div>

                <table class="table-fixed">

                    <thead>
                    <tr>
                        <th class="w-1/2">Name</th>
                        <th class="w-1/3">Email</th>
                        <th class="w-1/3">Actions</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr v-for="user in users" :key="user.id">
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td>
                            <inertia-link :href="`/admin/users/${user.id}/edit`">Edit</inertia-link>
                        </td>
                    </tr>
                    </tbody>

                </table>

                </div>
            </div>
        </div>
    </admin-layout>
</template>

<script>
import Welcome from '@/Jetstream/Welcome'
import AdminLayout from "../../../Layouts/AdminLayout";

export default {
    props: ['users', 'successMessage'],

    components: {
        AdminLayout,
        Welcome,
    },
}
</script>
