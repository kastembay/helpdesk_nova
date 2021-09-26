<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Actions\Actionable;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;

class Claim extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Claim::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'theme';

    /**
     * The relationships that should be eager loaded on index queries.
     *
     * @var array
     */
    public static $with = ['contact', 'user', 'priority'];


    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'theme',
        'appeal'
    ];

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Заявки';

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Claims');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Claim');
    }

    /**
     * Get the text for the create resource button.
     *
     * @return string|null
     */
    public static function createButtonLabel()
    {
        return __('Create');
    }

    /**
     * Get the text for the update resource button.
     *
     * @return string|null
     */
    public static function updateButtonLabel()
    {
        return __('Save');
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Text::make(__('Theme'), 'theme')->rules('required')->asHtml(),
            BelongsTo::make('contact')->rules('required'),
            BelongsTo::make('user')->rules('required'),
            BelongsTo::make('priority')->rules('required'),
            Trix::make(__('Appeal'),'appeal')
                ->rules('required', 'min:20')
                ->alwaysShow()
                ->hideFromIndex(),
            Boolean::make(__('Departure'), 'departure')
                ->trueValue(1)
                ->falseValue(0)
                ->hideFromIndex(),
            Boolean::make(__('Active'), 'active')
                ->trueValue(1)
                ->falseValue(0),
            File::make('Attachment'),

            HasMany::make('ClaimsComments')

        ];
    }


    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [
            new Metrics\MetricsClaims,
            new Metrics\CountDepartureClaims,
            new Metrics\OpenClaims
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            new Filters\CleamsStatus
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
