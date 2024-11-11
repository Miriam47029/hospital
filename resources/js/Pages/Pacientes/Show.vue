<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import DarkButton from '@/Components/DarkButton.vue';

const props = defineProps({
    paciente: {
        type: Object,
    },
    medicos: { 
        type: Array,
        default: () => [] // Valor predeterminado para evitar errores
    },
});
</script>

<template>
    <Head title="Paciente" />
    <AuthenticatedLayout>
        <template #header>
            <div class="inline-flex overflow-hidden mb-4 w-full">
                {{ paciente.nombre }} {{ paciente.apellidos }}
                <NavLink :href="route('pacientes.index')">
                    <DarkButton class="ml-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                        </svg>
                    </DarkButton>
                </NavLink>
            </div>
        </template>

        <div class="grid gap-6 bg-white mb-8 md:grid-cols-2 border rounded-lg">
            <div class="min-w-0 p-4 rounded-lg shadow-xs">
                <p>Nombre: <span class="text-gray-900 font-semibold">{{ paciente.nombre }} {{ paciente.apellidos }}</span></p>
                <p>Fecha de Nacimiento: <span class="text-gray-900 font-semibold">{{ paciente.fecha_nacimiento }}</span></p>
                <p>Dirección: <span class="text-gray-900 font-semibold">{{ paciente.direccion }}</span></p>
                <p>Teléfono: <span class="text-gray-900 font-semibold">{{ paciente.telefono }}</span></p>
                <p>Correo: <span class="text-gray-900 font-semibold">{{ paciente.correo }}</span></p>
                <p>Médicos:
                    <span v-if="medicos && medicos.length > 0">
                        <span v-for="(m, i) in medicos" :key="m.id" class="text-gray-900 font-semibold">
                            <span v-if="i === medicos.length - 1">{{ m.nombre }}</span>
                            <span v-else>{{ m.nombre + ', ' }}</span>
                        </span>
                    </span>
                    <span v-else>No hay médicos asignados.</span>
                </p>
            </div>

            <div class="min-w-0 p-4 rounded-lg shadow-xs">
                <img :src="`/storage/${paciente.image}`" :alt="paciente.nombre" class="w-full h-64 object-cover rounded-lg" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
