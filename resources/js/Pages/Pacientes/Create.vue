<script setup>
import Form from './Form.vue';

const props = defineProps({
    pacientes: {
        type: Object,
    },
});

</script>
<template>
    <Form :pacientes="pacientes"/>
</template>