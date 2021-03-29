<template>
    <h2 class="text-center">Badges</h2>
        <ul>
            <li class="py-2"><b>Badge Name:</b> {{userBadges.name}}</li>
            <li class="py-2"><b>Level:</b> {{userBadges.level}}</li>
            <li class="py-2"><b>Description</b> {{userBadges.description}}</li>
        </ul>
</template>

<script>
export default {
    props: ['userBadges'],
}
</script>
