<template>
  <div class="relative text-red-500 focus-within:text-red-600 dark:focus-within:text-red-400">
      <input
          class="rounded block w-full pl-10 mt-1 text-sm text-black dark:text-black dark:border-white dark:bg-white focus:border-red-600 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-red form-input"
          :value="modelValue"
          @input="$emit('update:modelValue', $event.target.value)"
          ref="input"
          :placeholder="text"
          :type="type"
          :required="required"
          :accept="accept"
      >
      <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
          <slot></slot>
      </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const props = defineProps({
  modelValue: String,
  text: String,
  type: String,
  required: Boolean,
  accept: String
});

const emit = defineEmits(['update:modelValue']);
const input = ref(null);

onMounted(() => {
  if (input.value && input.value.hasAttribute('autofocus')) {
      input.value.focus();
  }
});
</script>
