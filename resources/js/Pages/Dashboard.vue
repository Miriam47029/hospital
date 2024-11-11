<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js';
import { Bar } from 'vue-chartjs';
import { ref, onMounted } from 'vue';

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);

const props = defineProps({
    medicos: {
        type: Array,
        default: () => [],
    },
    pacientes: {
        type: Number,
        default: 0,
    },
});

console.log("Medicos recibidos:", props.medicos);
console.log("Total de pacientes recibidos:", props.pacientes);

const medicosNombres = ref([]);
const pacientesPorMedico = ref([]);
const colors = ref([]);
const chartData = ref(null);  // Se inicializa como null

const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
};

const randomColor = () => `rgb(${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)})`;

onMounted(() => {
    if (props.medicos && props.medicos.length > 0) {
        props.medicos.forEach((medico) => {
            medicosNombres.value.push(medico.nombre);
            pacientesPorMedico.value.push(medico.pacientes_count || 0); // Usa pacientes_count o 0 si es null
            colors.value.push(randomColor());
        });

        // Configura chartData después de que los datos están completos
        chartData.value = {
            labels: medicosNombres.value,
            datasets: [{
                label: 'Médicos',
                data: pacientesPorMedico.value,
                backgroundColor: colors.value,
            }],
        };
    } else {
        console.warn("No se recibieron datos de médicos o la lista de médicos está vacía.");
    }
});

</script>

<template>
    <Head title="Dashboard" />
    
    <AuthenticatedLayout>
        <template #header>
            Dashboard
        </template>
        
        <div class="p-4 bg-white rounded-lg shadow-xs">
            <div class="grid gap-6 mb-8 md:grid-cols-2">
                <!-- Tarjeta Total Médicos -->
                <div class="flex items-center p-4 bg-white rounded-lg shadow-xs w-full">
                    <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 7.5-2.25-1.313M21 7.5v2.25m0-2.25-2.25 1.313M3 7.5l2.25-1.313M3 7.5l2.25 1.313M3 7.5v2.25m9 3 2.25-1.313M12 12.75l-2.25-1.313M12 12.75V15m0 6.75 2.25-1.313M12 21.75V19.5m0 2.25-2.25-1.313m0-16.875L12 2.25l2.25 1.313M21 14.25v2.25l-2.25 1.313m-13.5 0L3 16.5v-2.25" />
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600">
                            Total Médicos
                        </p>
                        <p class="text-lg font-semibold text-gray-700">
                            {{ medicos.length }}
                        </p>
                    </div>
                </div>
                <!-- Tarjeta Total Pacientes -->
                <div class="flex items-center p-4 bg-white rounded-lg shadow-xs w-full">
                    <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.347a1.125 1.125 0 0 1 0 1.972l-11.54 6.347a1.125 1.125 0 0 1-1.667-.986V5.653Z" />
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600">
                            Total Pacientes
                        </p>
                        <p class="text-lg font-semibold text-gray-700">
                            {{ pacientes }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Gráfico Médicos por Paciente -->
            <div class="grid gap-6 bg-white mb-8 border rounded-lg">
                <div class="min-w-0 p-4 rounded-lg shadow-xs w-full">
                    <span class="text-lg p-4">Médicos por Paciente</span>
                    <div class="flex items-center w-full h-96">
                        <Bar v-if="chartData" :data="chartData" :options="chartOptions" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
