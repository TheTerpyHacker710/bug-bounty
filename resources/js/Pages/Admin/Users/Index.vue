<!--Page once navigated to /admin/users-->

<template>
    <admin-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users
            </h2>
        </template>

        <div v-if="successMessage" class="alert alert-success mt-4">
            {{ successMessage }}
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="my-5">
                <jet-button><a href="/admin/users/create" class="btn btn-primary">Create User</a></jet-button>
            </div>
        </div>

        <div class="py-3">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <table class="table-fixed">

                    <thead>
                    <tr>
                        <th class="px-4 py-2 w-20">Name</th>
                        <th class="px-4 py-2 w-20">Email</th>
                        <th class="px-4 py-2 w-20">Username</th>
                        <th class="px-4 py-2 w-30">Organisation ID</th>
                        <th class="px-4 py-2 w-20">Actions</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr v-for="user in users" :key="user.id">
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.username }}</td>
                        <td>{{ user.org_id }}</td>
                        <inertia-link :href="`/admin/users/${user.id}/edit`">Edit</inertia-link>
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
import JetButton from '@/Jetstream/Button'

export default {
    props: ['users', 'successMessage'],

    components: {
        AdminLayout,
        Welcome,
        JetButton,
    },
}
</script>
