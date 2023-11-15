<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Review;
use Filament\Forms\Form;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use App\Filament\Resources\ReviewResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ReviewResource\RelationManagers;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;
    
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';
    protected static ?string $navigationGroup = 'Games & Reviews';
    
    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make('Reviews')
                ->description('Rate the game here')
                ->schema([
            Select::make('game_id')
            ->label('Game Title')
            ->native(false)
            ->required()
            ->relationship('game','title'),
            TextInput::make('rating')
            ->placeholder('1-10')
            ->required()
            ->numeric()
            ->minValue(1)
            ->maxValue(10),
                ])->columns(2),
            Section::make('Commentary')
            ->description('Write your comment or suggestions here')
            ->schema([
            RichEditor::make('comment')
            ->required()
            ->columnSpanFull(),
            ])
        ]);
    }
    
    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            ImageColumn::make('game.cover')
            ->label('Cover'),
            TextColumn::make('game.title')
            ->sortable()
            ->searchable(),
            TextColumn::make('rating')
            ->sortable(),
            TextColumn::make('comment')
            ->toggleable(isToggledHiddenByDefault: true)
            ->words(3)
            
            ])
            ->filters([
                //
                ])
                ->actions([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    ])
                    ->bulkActions([
                        Tables\Actions\BulkActionGroup::make([
                            Tables\Actions\DeleteBulkAction::make(),
                        ]),
                        ])
                        ->emptyStateActions([
                            Tables\Actions\CreateAction::make(),
                        ]);
                    }
                    public static function infolist(Infolist $infolist): Infolist
                    {
                        return $infolist
                        ->schema([
                            ImageEntry::make('game.cover'),
                            TextEntry::make('game.title')
                            ->label('Game Title'),
                            TextEntry::make('rating'),
                            TextEntry::make('comment'),
                        ])->columns(1);
                    }
                    
                    public static function getRelations(): array
                    {
                        return [
                            //
                        ];
                    }
                    
                    public static function getPages(): array
                    {
                        return [
                            'index' => Pages\ListReviews::route('/'),
                            'create' => Pages\CreateReview::route('/create'),
                            'edit' => Pages\EditReview::route('/{record}/edit'),
                        ];
                    }    
                }
                