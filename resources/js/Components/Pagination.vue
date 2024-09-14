<template>
  <nav class="text-center mt-6">
    <Link v-for="link in links" :key="link.label" :href="link.url || ''" preserve-scroll v-html="link.label" :class="[
      'inline-block py-2 px-3 rounded-lg text-gray-700 text-sm',
      link.active ? 'bg-blue-300' : '',
      !link.url ? '!text-gray-700 cursor-not-allowed' : ''
    ]">
    </Link>
  </nav>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
  links: Array
})


</script>

<style scoped>
/* Optional: Add any custom styles here */
</style>