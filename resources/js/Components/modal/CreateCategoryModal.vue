<template>
  <modal :show="modelValue" max-width="lg">
    <div class="p-6">
      <h2 class="text-lg font-medium text-gray-900 mb-3">
        Create New Category
      </h2>
      <div class=" flex flex-col gap-3">

        <div class="flex flex-col gap-2">
          <InputLabel for="name" value="Name" />
          <Input id="name" type="text" v-model="form.name" />
          <InputError :message="form.errors.name" />
        </div>


      </div>
      <div class="mt-6 flex justify-end">
        <SecondaryButton @click="closeModal">Cancel</SecondaryButton>
        <PrimaryButton class="ml-3" @click="createCategory">
          Create
        </PrimaryButton>
      </div>

    </div>
  </modal>
</template>

<script setup>
// Imports
import Modal from "@/Components/Modal.vue";
import Input from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import { useForm } from "@inertiajs/vue3";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { showErrorDialog, showSuccessNotification } from "@/event-bus.js";



const form = useForm({
  name: '',
})

// Props & Emit
defineProps({
  modelValue: Boolean,
})
const emit = defineEmits(['update:modelValue'])

function createCategory() {
  form.post(route('dashboard.store'), {
    preserveScroll: true,
    onSuccess: () => {
      showSuccessNotification(`category have been create.`)

    },
    onError: errors => {
      let message = '';

      if (Object.keys(errors).length > 0) {
        message = errors[Object.keys(errors)[0]]
      } else {
        message = 'Error during category make. Please try again later.'
      }

      showErrorDialog(message)
    },
    onFinish: () => {
      closeModal()
      form.reset();
    }
  })
}

function closeModal() {
  emit('update:modelValue')
  form.clearErrors();
  form.reset()
}


</script>
