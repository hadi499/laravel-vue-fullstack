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
        <PrimaryButton class="ml-3" @click="editCategory">
          Edit
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
import { watch } from "vue";
import { Inertia } from "@inertiajs/inertia";
import { showErrorDialog, showSuccessNotification, showErrorNotification } from "@/event-bus.js";


const props = defineProps({
  modelValue: Boolean,
  category: Object,

})

// const form = useForm({
//   name: '',
// })
const form = useForm({
  name: props.category?.name,
  slug: props.category?.slug,
})


const emit = defineEmits(['update:modelValue', 'update:category'])

watch(() => props.category, (newCategory) => {
  form.name = newCategory?.name || '';
  form.slug = newCategory?.slug || '';

}, { immediate: true });


// const editCategory = () => {
//   Inertia.post(`/dashboard/${props.category.slug}/edit`, {
//     _method: "put",
//     name: form.name,
//     slug: form.slug,
//   });
// }

const editCategory = () => {
  form.put(`/dashboard/${props.category.slug}/edit`, {
    name: form.name,
    slug: form.slug,

    onSuccess: () => {
      showSuccessNotification(`category updated.`)

    },
    onError: errors => {
      let message = '';

      if (Object.keys(errors).length > 0) {
        message = errors[Object.keys(errors)[0]]
      } else {
        message = 'Error during category update. Please try again later.'
      }

      showErrorNotification(message)
    },
    onFinish: () => {
      closeModal()
      form.reset();
    }
  });
}



function closeModal() {

  emit('update:modelValue')
  form.clearErrors();
  form.reset()

}




</script>
