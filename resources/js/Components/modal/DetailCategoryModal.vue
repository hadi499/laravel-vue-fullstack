<template>

  <modal :show="modelValue" max-width="lg">
    <div class="p-3">
      <h2 class="text-lg font-medium text-gray-900 mb-3">
        Detail Category
      </h2>
      <div>
        <table class=" bg-white border border-gray-300 w-full">
          <thead>
            <tr class="bg-blue-100 border-b">
              <th class="text-left py-3 px-4 font-semibold text-sm text-gray-600">Name</th>
              <th class="text-left py-3 px-4 font-semibold text-sm text-gray-600">Slug</th>

            </tr>
          </thead>
          <tbody>
            <tr class="">
              <td class="py-3 px-4 border-b">{{ category.name }}</td>
              <td class="py-3 px-4 border-b">{{ category.slug }}</td>

            </tr>

            <!-- Add more rows as needed -->
          </tbody>
        </table>
      </div>

      <div class="mt-6 flex justify-end">
        <PrimaryButton @click="closeModal">Close</PrimaryButton>

      </div>


    </div>
  </modal>


</template>

<script setup>
import Modal from "@/Components/Modal.vue"
import PrimaryButton from "@/Components/PrimaryButton.vue"

defineProps({
  modelValue: Boolean,
  category: Object,


})

const emit = defineEmits(['update:modelValue'])

function closeModal() {
  emit('update:modelValue')
}


</script>