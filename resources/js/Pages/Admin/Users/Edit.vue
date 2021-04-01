<!--Page once navigated to /admin/users/edit-->

<template>
    <admin-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Users
            </h2>
        </template>

        <div class="py-3">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <form action="#" method="PATCH" class="my-5" @submit.prevent="updateUser">
                        <div class="form-group">
                            <jet-label for="name">Name</jet-label>
                            <input type="text" class="form-control" id="name" placeholder="Name" v-model="form.name">
                            <div v-if="errors.name">{{ errors.name }}</div>
                        </div>
                        <div class="form-group">
                            <jet-label for="email">Email</jet-label>
                            <input type="email" class="form-control" id="email" placeholder="Email" v-model="form.email">
                            <div v-if="errors.email">{{ errors.email }}</div>
                        </div>
                        <div class="form-group">
                            <jet-label for="email">Password</jet-label>
                            <input type="password" class="form-control" id="password" placeholder="Password" v-model="form.password">
                            <div v-if="errors.password">{{ errors.password }}</div>
                        </div>
                        <div class="form-group">
                            <jet-label for="username">Username</jet-label>
                            <input type="text" class="form-control" id="username" placeholder="Username" v-model="form.username">
                            <div v-if="errors.username">{{ errors.username }}</div>
                        </div>
                        <div class="form-group">
                            <jet-label for="org_id">Organisation ID</jet-label>
                            <input type="text" class="form-control" id="org_id" placeholder="org_id" v-model="form.org_id">
                            <div v-if="errors.org_id">{{ errors.org_id }}</div>
                        </div>
                        <div class="form-group">
                            <jet-label for="org_id">Organisation Name</jet-label>
                            <input type="text" class="form-control" id="org_name" placeholder="org_name" v-model="form.org_name">
                            <div v-if="errors.org_name">{{ errors.org_name }}</div>
                        </div>

                        <jet-button type="submit" class="btn btn-primary">Update User</jet-button>
                     </form>

                <jet-button class="btn btn-danger" @click="deleteUser()">Delete User</jet-button>
                </div>
            </div>
        </div>
    </admin-layout>
</template>

<script>
import Welcome from '@/Jetstream/Welcome'
import AdminLayout from "../../../Layouts/AdminLayout";
import JetButton from '@/Jetstream/Button'
import JetLabel from '@/Jetstream/Label'

export default {
    props: ['user', 'errors'],

    components: {
        AdminLayout,
        Welcome,
        JetButton,
        JetLabel,
    },

    data() {
        return {
            loading: false,
            form: {
                name: this.user.name,
                email: this.user.email,
                username: this.user.username,
                org_id: this.user.org_id,
                org_name: this.user.org_name,
            }
        }
    },

    methods: {
        deleteUser() {
            if (confirm('Are you sure you want to delete this user?')) {
                this.$inertia.delete(`/admin/users/${this.user.id}`)
                    .then(() => {

                    })
            }
        },

        updateUser() {
            this.loading = true;
            this.$inertia.patch(`/admin/users/${this.user.id}`, this.form)
                .then(() => {
                    this.loading = false;
                })
        }
    },
}
</script>
