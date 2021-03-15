<!--Page once navigated to /admin-->

<template>
    <admin-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Reports
            </h2>
        </template>

        <div class="py-3">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    Reports
                </div>
            </div>
        </div>
    </admin-layout>
</template>

<script>
import Welcome from '@/Jetstream/Welcome'
import AdminLayout from "../../Layouts/AdminLayout";

export default {
    components: {
        AdminLayout,
        Welcome,
    },
}
</script>
