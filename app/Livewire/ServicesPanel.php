<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Service;
use Livewire\WithPagination;

class ServicesPanel extends Component
{
    use WithPagination;

    public $name, $description, $type, $status = true, $search = '', $filterType = '';

    protected $updatesQueryString = ['search', 'filterType'];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterType()
    {
        $this->resetPage();
    }
    public $serviceId;
    public $isEdit = false;

    protected $rules = [
        'name' => 'required|string',
        'description' => 'required|string',
        'type' => 'required|in:mutual_fund,sip,insurance',
        'status' => 'boolean'
    ];

    public function create()
    {
        $this->resetFields();
        $this->isEdit = false;
    }

    public function store()
    {
        $this->validate();

        Service::create([
            'name' => $this->name,
            'description' => $this->description,
            'type' => $this->type,
            'status' => $this->status
        ]);

        session()->flash('success', 'Service created successfully.');
        $this->resetFields();
    }

    public function edit($id)
    {
        $service = Service::findOrFail($id);
        $this->serviceId = $service->id;
        $this->name = $service->name;
        $this->description = $service->description;
        $this->type = $service->type;
        $this->status = $service->status;
        $this->isEdit = true;
    }

    public function update()
    {
        $this->validate();

        $service = Service::findOrFail($this->serviceId);
        $service->update([
            'name' => $this->name,
            'description' => $this->description,
            'type' => $this->type,
            'status' => $this->status
        ]);

        session()->flash('success', 'Service updated successfully.');
        $this->resetFields();
    }

    public function delete($id)
    {
        Service::destroy($id);
        session()->flash('success', 'Service deleted successfully.');
    }

    public function toggleStatus($id)
    {
        $service = Service::findOrFail($id);
        $service->status = !$service->status;
        $service->save();
    }

    public function resetFields()
    {
        $this->serviceId = null;
        $this->name = '';
        $this->description = '';
        $this->type = '';
        $this->status = true;
    }

    public function render()
    {
        $services = Service::where('name', 'like', "%{$this->search}%")
            ->when($this->filterType, fn($q) => $q->where('type', $this->filterType))
            ->latest()
            ->paginate(10);

        return view('livewire.services-panel', compact('services'))
            ->layout('layouts.app');
    }
}
