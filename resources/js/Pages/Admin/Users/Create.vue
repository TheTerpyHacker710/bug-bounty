<!--Page once navigated to /users/create-->

<template>
    <admin-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Users
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

                <form action="/users" method="POST" class="my-5" @submit.prevent="createUser">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name"
                               placeholder="Name" v-model="form.name">
                        <div v-if="errors.name">{{ errors.name }}</div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email"
                               placeholder="Email" v-model="form.email">
                        <div v-if="errors.email">{{ errors.email }}</div>
                    </div>
                    <div class="form-group">
                        <label for="email">Password</label>
                        <input type="password" class="form-control" id="password"
                               placeholder="Password" v-model="form.password">
                        <div v-if="errors.password">{{ errors.password }}</div>
                    </div>
                    <button type="submit" class="btn btn-primary">Create User</button>
                </form>
            </div>
        </div>
    </admin-layout>
</template>

<script>
import Welcome from '@/Jetstream/Welcome'
import Button from "../../../Jetstream/Button";
import AdminLayout from "../../../Layouts/AdminLayout";

export default {
    props: ['errors'],

    components: {
        Button,
        AdminLayout,
        Welcome,
    },
    data() {
        return {
            form: {
                name: '',
                email: '',
                password: '',
            }
        }
        },
            methods: {
            createUser() {
                this.$inertia.post('/admin/users', this.form)
                .then(() => {
                    //code
                })
            }
        }
    }
</script>
