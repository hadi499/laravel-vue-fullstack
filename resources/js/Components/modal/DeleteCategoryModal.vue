<template>
  <modal :show="modelValue" max-width="lg" @close="closeModal">
    <div class="p-6">
      <h2 class="text-lg font-medium text-gray-900 mb-3">Delete category</h2>
      <p>Are you sure you want to delete the category "{{ category.name }}"?</p>
      <div class="mt-6 flex justify-end">
        <SecondaryButton @click="closeModal">Cancel</SecondaryButton>
        <DeleteButton class="ml-3" @click="confirmDelete">Delete</DeleteButton>
      </div>
    </div>
  </modal>
</template>

<script setup>
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DeleteButton from '@/Components/DeleteButton.vue'
import { Inertia } from "@inertiajs/inertia";


const props = defineProps({
  modelValue: Boolean,
  category: Object
});

const emit = defineEmits(['update:modelValue']);

function closeModal() {
  emit('update:modelValue', false);
}

function confirmDelete() {
  Inertia.delete(`/dashboard/${props.category.id}`, {
    onFinish: () => {
      closeModal();
    }
  });
}
</script>
