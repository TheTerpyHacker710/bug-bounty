<!--Page once navigated to /users/edit-->

<template>
    <admin-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Users
            </h2>
        </template>

        <!--        <div class="py-3">-->
        <!--            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">-->
        <!--                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">-->
        <!--                    List of Users-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->

        <div class="py-3">
            <div class="col-md-6">

                <!--                <div v-if="Object.keys(errors).length > 0" class="alert alert-danger mt-4">-->
                <!--                    {{ errors[Object.keys(errors)[0]][0] }}-->
                <!--                </div>-->

                <form action="#" method="PATCH" class="my-5" @submit.prevent="updateUser">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" placeholder="Name" v-model="form.name">
                        <div v-if="errors.name">{{ errors.name }}</div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Email" v-model="form.email">
                        <div v-if="errors.email">{{ errors.email }}</div>
                    </div>
                    <div class="form-group">
                        <label for="email">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Password" v-model="form.password">
                        <div v-if="errors.password">{{ errors.password }}</div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update User</button>
                </form>

                <button class="btn btn-danger" @click="deleteUser()">Delete User</button>
            </div>
        </div>
    </admin-layout>
</template>

<script>
import Welcome from '@/Jetstream/Welcome'
import Button from "../../../Jetstream/Button";
import AdminLayout from "../../../Layouts/AdminLayout";

export default {
    props: ['user', 'errors'],

    components: {
        // Button,
        AdminLayout,
        Welcome,
    },

    data() {
        return {
            loading: false,
            form: {
                name: this.user.name,
                email: this.user.email,
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
