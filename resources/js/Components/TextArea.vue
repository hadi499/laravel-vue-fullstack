<script setup>
import { onMounted, defineExpose, ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const textareaRef = ref(null);

onMounted(() => {
    if (textareaRef.value.hasAttribute('autofocus')) {
        textareaRef.value.focus();
    }
});

defineExpose({ focus: () => textareaRef.value.focus() });
</script>

<template>
    <textarea
        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
        v-model="model"
        ref="textareaRef"
    ></textarea>
</template>
