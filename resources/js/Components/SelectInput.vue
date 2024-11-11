<template>
    <div class="relative text-red-500 focus-within:text-red-600 dark:focus-within:text-red-400">
      <select
        class="rounded block w-full pl-10 mt-1 text-sm text-black dark:text-black dark:border-white dark:bg-white focus:border-red-600 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-red form-input"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        ref="input"
        :placeholder="text"
        :required="required"
      >
        <option value="" selected>{{ text }}</option>
        <option v-for="op in options" :key="op.id" :value="op.id">
          {{ op.id }} - {{ op.nombre }}
        </option>
      </select>
      <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
        <slot></slot>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  
  const props = defineProps({
    modelValue: [String, Number],
    text: String,
    options: Array, // Asegúrate de que options sea un array de objetos que incluyen id y nombre
    required: Boolean,
  });
  
  const emit = defineEmits(['update:modelValue']);
  const input = ref(null);
  
  // Verificamos que options tenga los datos correctos
  onMounted(() => {
    console.log('Pacientes recibidos en SelectInput:', props.options);
  });
  </script>
  