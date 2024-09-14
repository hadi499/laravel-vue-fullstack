<template>
  <modal :show="modelValue" max-width="lg" @close="closeModal">
    <div class="p-6">
      <h2 class="text-lg font-medium text-gray-900 mb-3">Delete Post</h2>
      <p>Are you sure you want to delete the post <span class="font-semibold">"{{ post.title }}"</span> ?</p>
      <div class="mt-6 flex justify-end">
        <SecondaryButton @click="closeModal">Cancel</SecondaryButton>
        <DeleteButton class="ml-3" @click="deletePost">Delete</DeleteButton>
      </div>
    </div>
  </modal>
</template>

<script setup>
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DeleteButton from '@/Components/DeleteButton.vue'
import { defineProps, defineEmits } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
  modelValue: Boolean,
  post: Object
});

const emit = defineEmits(['update:modelValue']);

function closeModal() {
  emit('update:modelValue', false);
}

function deletePost() {
  Inertia.delete(`/posts/${props.post.id}`, {
    onFinish: () => {
      closeModal();
    }
  });
}
</script>