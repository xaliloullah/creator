<script setup>
import { ref } from 'vue';

const tasks = ref([]);
const newTask = ref('');

const addTask = () => {
    if (newTask.value.trim()) {
        tasks.value.push(newTask.value);
        newTask.value = '';
    }
};
</script>

<template>
    <div class="p-5">
        <h2 class="text-lg font-bold">Liste des tâches</h2>
        <input v-model="newTask" placeholder="Ajouter une tâche..." class="border p-2 rounded mr-2">
        <button @click="addTask" class="bg-blue-500 text-white px-4 py-2 rounded">Ajouter</button>

        <ul class="mt-4">
            <li v-for="(task, index) in tasks" :key="index" class="mt-2">{{ task }}</li>
        </ul>
    </div>
</template>
