<script setup>
import Form from './Form.vue';

const props = defineProps({
    pacientes: Object,
    medico: Array,
    pacienteOfMedico: Array,
});
</script>

<template>
    <Form :pacientes="pacientes" :medico="medico" :pacienteOfMedico="pacienteOfMedico" />
</template>
