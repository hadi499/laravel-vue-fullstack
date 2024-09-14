<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Input from '@/Components/Input.vue';

import { Inertia } from "@inertiajs/inertia";




const user = usePage().props.auth.user;

const form = useForm({

  avatar: null,
  oldAvatar: user.avatar,
});

const submit = () => {
  Inertia.post(route('avatar.update'), {
    _method: "put",

    avatar: form.avatar,
    oldAvatar: form.oldAvatar,

  });
}



</script>

<template>
  <section>
    <header>
      <h2 class="text-lg font-medium text-gray-900">Profile Avatar</h2>

      <p class="mt-1 text-sm text-gray-600">
        Update your avatar
      </p>
    </header>

    <form @submit.prevent="submit" class="mt-6 space-y-6">
      <div>
        <InputLabel for="avatar" value="Image" />
        <input type="hidden" name="oldAvatar" v-model="form.oldAvatar">
        <Input id="avatar" type="file" @input="form.avatar = $event.target.files[0]" />
      </div>


      <div class="flex items-center gap-4">
        <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

        <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
          leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
          <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
        </Transition>
      </div>
    </form>
  </section>
</template>
