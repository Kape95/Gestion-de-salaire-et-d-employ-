<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:employers,email',
            'contact' => 'required|string|max:20|unique:employers,contact',
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:500',
            'date_naissance' => 'nullable|date|before:today',
            'date_embauche' => 'nullable|date|before_or_equal:today',
            'poste' => 'nullable|string|max:255',
            'montant_journalier' => 'required|numeric|min:0',
            'departement_id' => 'required|integer|exists:departements,id',
        ];
    }

    public function messages()
    {
        return [
            'nom.required' => 'Le nom est requis.',
            'nom.max' => 'Le nom ne peut pas dépasser 255 caractères.',
            'prenom.required' => 'Le prénom est requis.',
            'prenom.max' => 'Le prénom ne peut pas dépasser 255 caractères.',
            'email.required' => 'L\'email est requis.',
            'email.email' => 'L\'email doit être une adresse email valide.',
            'email.max' => 'L\'email ne peut pas dépasser 255 caractères.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'contact.required' => 'Le numéro de téléphone est requis.',
            'contact.max' => 'Le numéro de téléphone ne peut pas dépasser 20 caractères.',
            'contact.unique' => 'Ce numéro de téléphone est déjà utilisé.',
            'telephone.max' => 'Le numéro de téléphone ne peut pas dépasser 20 caractères.',
            'adresse.max' => 'L\'adresse ne peut pas dépasser 500 caractères.',
            'date_naissance.date' => 'La date de naissance doit être une date valide.',
            'date_naissance.before' => 'La date de naissance doit être antérieure à aujourd\'hui.',
            'date_embauche.date' => 'La date d\'embauche doit être une date valide.',
            'date_embauche.before_or_equal' => 'La date d\'embauche ne peut pas être dans le futur.',
            'poste.max' => 'Le poste ne peut pas dépasser 255 caractères.',
            'montant_journalier.required' => 'Le montant journalier est requis.',
            'montant_journalier.numeric' => 'Le montant journalier doit être un nombre.',
            'montant_journalier.min' => 'Le montant journalier doit être positif.',
            'departement_id.required' => 'Le département est requis.',
            'departement_id.integer' => 'Le département doit être un nombre entier.',
            'departement_id.exists' => 'Le département sélectionné n\'existe pas.',
        ];
    }
}
