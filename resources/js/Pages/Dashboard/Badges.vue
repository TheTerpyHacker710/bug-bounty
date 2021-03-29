<template>
    <h2 class="text-center">Badges</h2>
        <ul>
            <li class="py-2"><b>Badge Name:</b> {{badge.name}}</li>
            <li class="py-2"><b>Level:</b> {{badge.level}}</li>
            <li class="py-2"><b>Description</b> {{badge.description}}</li>
        </ul>
</template>

<script>
export default {
    props: ['badge'],
}
</script>
