<template>
    <h2 class="text-center text-lg">Account Information</h2>
        <ul>
            <li class="py-2"><b>Name:</b> {{userInfo.name}}</li>
            <li class="py-2"><b>Username:</b> {{userInfo.username}}</li>
            <li class="py-2"><b>Email:</b> {{userInfo.email}}</li>
            <li class="py-2"><b>Staff/Student Number:</b> {{userInfo.org_id}}</li>
            <li class="py-2"><b>Orginization:</b> {{userInfo.org_name}}</li>
            <li class="text-right"><inertia-link href="/user/profile" as="button" type="button" class="focus:outline-none text-white text-sm py-1 px-2.5 rounded-md bg-gray-700 hover:bg-gray-900 hover:shadow-lg">Change Details</inertia-link></li>
        </ul>
</template>

<script>
export default {
    props: ['userInfo']
}
</script>