<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import WarningButton from '@/Components/WarningButton.vue';
import DarkButton from '@/Components/DarkButton.vue';
import InputGroup from '@/Components/InputGroup.vue';
import SelectInput from '@/Components/SelectInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    medicos: Array,
    pacientes: Array,
});
console.log('Pacientes en el componente principal:', props.pacientes);

const form = useForm({ nombre: '', especialidad: '', telefono: '', email: '', paciente_id: '' });
const v = ref({ id: '', nombre: '', apellidos: '', pacientes: '' });
const showModalView = ref(false);
const showModalForm = ref(false);
const showModalDel = ref(false);
const nomPa = ref(''); // Variable para el título dinámico
const operacion = ref(1);
const msj = ref('');
const classMsj = ref('hidden');

const openModalView = (a) => {
    v.value.nombre = a.nombre;
    v.value.especialidad = a.especialidad;
    v.value.telefono = a.telefono;
    v.value.email = a.email;
    v.value.pacientes = a.pacientes;
    showModalView.value = true;
};

const openModalForm = (op, a = null) => {
    operacion.value = op;
    if (op === 1) {
        nomPa.value = 'Crear Medico'; 
        form.reset();
    } else {
        nomPa.value = 'Editar Medico'; 
        form.nombre = a.nombre;
        form.especialidad = a.especialidad;
        form.telefono = a.telefono;
        form.email = a.email;
        form.paciente_id = a.paciente_id;
        v.value.id = a.id;
    }
    showModalForm.value = true;
}

const openModalDel = (a) => {
    showModalDel.value = true;
	v.value.id = a.id;
	v.value.nombre = a.nombre+' '+a.especialidad;
	
}

const closeModalView = () => {
    showModalView.value = false;
}

const closeModalForm = () => {
    showModalForm.value = false;
    form.reset();
}

const closeModalDel = () => {
    showModalDel.value = false;
}

const save = () => {
    if (operacion.value == 1) {
        form.post(route('medicos.store'), {
            onSuccess: () => { ok('Medico Creado') }
        });
    } else {
        form.put(route('medicos.update', v.value.id), {
            onSuccess: () => { ok('Medico Actualizado') }
        });
    }
}

const ok = (m) => {
    if (operacion.value === 2) {
        closeModalForm();
    }
    closeModalDel();
    form.reset();
    msj.value = m;
    classMsj.value = 'visible'; 
	setTimeout(() => {
		classMsj.value = 'hidden';
	},8000);
}

const deleteMedico = () =>{
	form.delete(route('medicos.destroy',v.value.id),{
		onSuccess: () => {ok('Medico Eliminado')}
	})
}

</script>

<template>
    <Head title="Medicos" />

    <AuthenticatedLayout>
        <template #header>
            Medicos
			<DarkButton @click="openModalForm(1)">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
					<path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
				</svg>
			</DarkButton>
		</template>
		
		<div class="inline-flex overflow-hidden mb-4 w-full bg-white rounded-lg shadow-md" :class="classMsj">
				<div class="flex justify-center items-center w-12 bg-red-500">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                    </svg>

				</div>
				
				<div class="px-4 py-2 -mx-3">
					<div class="mx-3">
						<span class="font-semibold text-black">Success</span>
						<p class="text-sm text-gray-600">{{ msj }}</p>
					</div>
				</div>
			</div>

		<div class="w-full overflow-hidden rounded-lg border shadow-md">
			<div class="w-full overflow-x-auto bg-red">
				<table class="w-full whitespace-no-wrap">
					<thead>
						<tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
							<th class="px-4 py-3">#</th>
							<th class="px-4 py-3">Nombre</th>
							<th class="px-4 py-3">Especialidad</th>
							<th class="px-4 py-3">Telefono</th>
							<th class="px-4 py-3">Email</th>
							<th class="px-4 py-3">Paciente_id</th>
							<th class="px-4 py-3">Detail</th>
							<th class="px-4 py-3">Edit</th>
							<th class="px-4 py-3">Delete</th>
						</tr>
					</thead>
					<tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
						<tr v-for="a,i in medicos" :key="a.id" class="text-gray-500">
							<td class="px-4 py-3 text-sm">{{ (i+1) }}</td>
							<td class="px-4 py-3 text-sm">{{ a.nombre }}</td>
							<td class="px-4 py-3 text-sm">{{ a.especialidad }}</td>
							<td class="px-4 py-3 text-sm">{{ a.telefono }}</td>
							<td class="px-4 py-3 text-sm">{{ a.email }}</td>
							<td class="px-4 py-3 text-sm">{{ a.paciente_id }}</td>
							<td class="px-4 py-3 text-sm">
								<SecondaryButton @click="openModalView(a)">
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
										<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
										<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
									</svg>
								</SecondaryButton>
							</td>
							<td class="px-4 py-3 text-sm">
								<WarningButton @click="openModalForm(2,a)">
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
										<path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
									</svg>
								</WarningButton>
							</td>
							<td class="px-4 py-3 text-sm">
								<DangerButton @click="openModalDel(a)">
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
										<path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
									</svg>
								</DangerButton>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<!-- Modal para Ver Detalles -->
		<Modal :show="showModalView" @close="closeModalView">
			<div class="p-6">
				<p>Medico: <span class="text-lg font-medium text-gray-900">{{ v.nombre }}</span></p>
				<p>Especialidad: <span class="text-lg font-medium text-gray-900">{{ v.especialidad }}</span></p>
				<p>Teléfono: <span class="text-lg font-medium text-gray-900">{{ v.telefono }}</span></p>
				<p>Email: <span class="text-lg font-medium text-gray-900">{{ v.email }}</span></p>
				<p>Pacientes:</p>
				<ol>
					<li v-for="(b, i) in v.pacientes" :key="i" class="text-lg font-medium text-gray-900">
						{{ (i + 1) + ') ' + b.nombre }}
					</li>
				</ol>
			</div>
			<div class="m-6 flex justify-end">
				<SecondaryButton @click="closeModalView">Cancel</SecondaryButton>
			</div>
		</Modal>

		<!-- Modal para Formulario -->
		<Modal :show="showModalForm" @close="closeModalForm">
			<div class="p-6">
				<h2 class="text-lg font-medium text-gray-600">
                    {{ nomPa }}
                </h2>
				<div class="mt-6 mb-6 space-y-6 max-w-xl">
					<InputGroup :text="'Nombre'" :required="true" v-model="form.nombre" :type="text">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
							<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
						</svg>
					</InputGroup>
					<InputError class="mt-1" :message="form.errors.nombre"></InputError>

					<InputGroup :text="'Especialidad'" :required="true" v-model="form.especialidad" :type="text">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                       </svg>

					</InputGroup>
					<InputError class="mt-1" :message="form.errors.especialidad"></InputError>

					<!-- Campo para Teléfono -->
					<InputGroup :text="'Teléfono'" :required="true" v-model="form.telefono" :type="text">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                       </svg>

					</InputGroup>
					<InputError class="mt-1" :message="form.errors.telefono"></InputError>

					<!-- Campo para Email -->
					<InputGroup :text="'Email'" :required="true" v-model="form.email" :type="text">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Zm0 0c0 1.657 1.007 3 2.25 3S21 13.657 21 12a9 9 0 1 0-2.636 6.364M16.5 12V8.25" />
                        </svg>

					</InputGroup>
					<InputError class="mt-1" :message="form.errors.email"></InputError>

					<!--CAMPO DEL PACIENTE_ID-->
					<!-- Implementación en tu componente principal -->
					<SelectInput :text="'Seleccione un paciente'" :required="true" v-model="form.paciente_id" :options="props.pacientes">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                        </svg>
                    </SelectInput>
                    <InputError class="mt-1" :message="form.errors.paciente_id"></InputError>
					<PrimaryButton @click="save">Save</PrimaryButton>
				</div>
			</div>
			<div class="m-6 flex justify-end">
				<SecondaryButton @click="closeModalForm">Cancel</SecondaryButton>
			</div>
		</Modal>

		<!-- Modal para Eliminar -->
		<Modal :show="showModalDel" @close="closeModalDel">
			<div class="p-6">
				<p class="text-2xl text-gray-900">
					Seguro Eliminar al medic@:  
					<span class="text-2xl font-medium text-gray-900">{{ v.nombre }}</span> ? </p>
					<PrimaryButton @click="deleteMedico">Si, Eliminar</PrimaryButton>
			</div>
			<div class="m-6 flex justify-end">
				<SecondaryButton @click="closeModalDel">Cancel</SecondaryButton>
			</div>
		</Modal>

	</AuthenticatedLayout>
</template>

