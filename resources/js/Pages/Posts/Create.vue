<script setup>
import { useForm, Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import InputLabel from '@/Components/InputLabel.vue'
import Input from '@/Components/Input.vue'
import Button from '@/Components/Button.vue'
import TextAreaInput from '@/Components/TextArea.vue'
import InputError from '@/Components/InputError.vue'
import Editor from '@/Components/Editor.vue'

defineProps({
  categories: Array,
})

const form = useForm({
  title: "",
  image: null,
  category_id: "",
  body: "",
  previewImage: null, // Menambahkan properti untuk preview gambar
})

const handleImageChange = (event) => {
  const file = event.target.files[0];
  if (file) {
    form.image = file;
    form.previewImage = URL.createObjectURL(file); // Menghasilkan URL untuk pratinjau gambar
  } else {
    form.previewImage = null;
  }
}

const submit = () => {
  form.post(route("posts.store"), {
    onSuccess: () => {
      // Perform any additional actions after success
    },
    onFinish: () => {
      form.reset('title', 'image', 'category_id', 'body', 'previewImage');
    }
  });
};
</script>

<template>

  <Head title="Create Post" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Post</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex justify-center">
        <form class="p-4 bg-white flex flex-col gap-3 w-[600px]" @submit.prevent="submit">
          <div class="flex flex-col gap-2">
            <InputLabel for="title" value="Title" />
            <Input class="w-full" id="title" type="text" v-model="form.title" />
            <InputError :message="form.errors.title" />
          </div>

          <div class="flex flex-col gap-2">
            <InputLabel for="image" value="Image" />
            <Input id="image" type="file" @input="handleImageChange" />
            <InputError :message="form.errors.image" />

            <!-- Pratinjau Gambar -->
            <div v-if="form.previewImage" class="mt-2">
              <img :src="form.previewImage" alt="Image Preview" class="w-36 h-auto rounded-lg" />
            </div>
          </div>

          <div>
            <InputLabel for="category_id" value="Category" />
            <select v-model="form.category_id" id="category_id" name="category_id" class="
                mt-1
                block
                w-full
                pl-3
                pr-10
                py-2
                text-base
                border-gray-300
                focus:outline-none focus:ring-indigo-500 focus:border-indigo-500
                sm:text-sm
                rounded-md
              ">
              <option value="" disabled>Select a category</option>
              <option v-for="category in categories" :key="category.id" :value="category.id">
                {{ category.name }}
              </option>
            </select>
            <InputError class="mt-2" :message="form.errors.category_id" />
          </div>

          <div class="flex flex-col gap-2">
            <InputLabel for="body" value="Body" />
            <Editor v-model="form.body" />
            <InputError :message="form.errors.body" />
          </div>

          <div class="flex items-center justify-end mt-4">
            <Button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
              Create
            </Button>
          </div>
        </form>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
